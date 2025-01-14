<?php

declare(strict_types=1);

namespace PoP\CacheControl\DirectiveResolvers;

use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoP\ComponentModel\Engine\EngineIterationFieldSet;
use PoP\ComponentModel\Feedback\EngineIterationFeedbackStore;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\FieldQuery\QueryHelpers;
use PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\LeafField;
use PoP\GraphQLParser\Spec\Parser\Ast\RelationalField;

class NestedFieldCacheControlDirectiveResolver extends AbstractCacheControlDirectiveResolver
{
    /**
     * It must execute before anyone else!
     */
    public function getPriorityToAttachToClasses(): int
    {
        return PHP_INT_MAX;
    }

    /**
     * If any argument is a field, then this directive will involve them to calculate the minimum max-age
     */
    public function resolveCanProcess(
        RelationalTypeResolverInterface $relationalTypeResolver,
        string $directiveName,
        array $directiveArgs,
        FieldInterface $field,
        array &$variables
    ): bool {
        if ($fieldArgs = $this->getFieldQueryInterpreter()->getFieldArgs($field->asFieldOutputQueryString())) {
            $fieldArgElems = QueryHelpers::getFieldArgElements($fieldArgs);
            return $this->isFieldArgumentValueAFieldOrAnArrayWithAField($fieldArgElems, $variables);
        }
        return false;
    }

    protected function isFieldArgumentValueAFieldOrAnArrayWithAField($fieldArgValue, array &$variables): bool
    {
        $fieldArgValue = $this->getFieldQueryInterpreter()->maybeConvertFieldArgumentValue($fieldArgValue, $variables);
        // If it is an array, we must evaluate if any of its items is a field
        if (is_array($fieldArgValue)) {
            return array_reduce(
                (array)$fieldArgValue,
                function ($carry, $item) use ($variables) {
                    return $carry || $this->isFieldArgumentValueAFieldOrAnArrayWithAField($item, $variables);
                },
                false
            );
        }
        return $this->getFieldQueryInterpreter()->isFieldArgumentValueAField($fieldArgValue);
    }

    public function getMaxAge(): ?int
    {
        // This value doesn't really matter, it will never be called anyway
        return null;
    }

    /**
     * Calculate the max-age involving also the composed fields
     *
     * @param array<string|int,EngineIterationFieldSet> $idFieldSet
     * @param array<array<string|int,EngineIterationFieldSet>> $succeedingPipelineIDFieldSet
     */
    public function resolveDirective(
        RelationalTypeResolverInterface $relationalTypeResolver,
        array $idFieldSet,
        array $succeedingPipelineDirectiveResolverInstances,
        array $objectIDItems,
        array $unionDBKeyIDs,
        array $previousDBItems,
        array &$succeedingPipelineIDFieldSet,
        array &$dbItems,
        array &$variables,
        array &$messages,
        EngineIterationFeedbackStore $engineIterationFeedbackStore,
    ): void {
        if ($idFieldSet) {
            // Iterate through all the arguments, calculate the maxAge for each of them,
            // and then return the minimum value from all of them and the directiveName for this field
            /** @var FieldInterface[] */
            $fields = [];
            foreach ($idFieldSet as $id => $fieldSet) {
                $fields = array_merge(
                    $fields,
                    $fieldSet->fields
                );
            }
            $fields = array_values(array_unique($fields));
            // Extract all the field arguments which are fields or have fields themselves
            $fieldArgElems = array_unique(GeneralUtils::arrayFlatten(array_map(
                function (FieldInterface $field) {
                    if ($fieldArgs = $this->getFieldQueryInterpreter()->getFieldArgs($field->asFieldOutputQueryString())) {
                        return QueryHelpers::getFieldArgElements($fieldArgs);
                    }
                    return [];
                },
                $fields
            )));
            // If any element is an array represented as a string, like "[time()]"
            // when doing /?query=extract(echo([time()]),0), then extract it and merge it into the main array
            $nestedFields = array_unique(GeneralUtils::arrayFlatten(
                (array)$this->getFieldQueryInterpreter()->maybeConvertFieldArgumentArrayOrObjectValue($fieldArgElems),
                true
            ));
            // Extract the composed fields which are either a field, or an array which contain a field
            $nestedFields = array_filter(
                $nestedFields,
                function ($fieldArgValue) use ($variables) {
                    return $this->isFieldArgumentValueAFieldOrAnArrayWithAField($fieldArgValue, $variables);
                }
            );
            $fieldDirectiveFields = array_unique(array_merge(
                $nestedFields,
                array_map(
                    // To evaluate on the root fields, we must remove the fieldArgs, to avoid a loop
                    function (FieldInterface $field): FieldInterface {
                        if ($field instanceof RelationalField) {
                            return new RelationalField(
                                $field->getName(),
                                $field->getAlias(),
                                [],
                                $field->getFieldsOrFragmentBonds(),
                                $field->getDirectives(),
                                $field->getLocation(),
                            );
                        }
                        /** @var LeafField $field */
                        return new LeafField(
                            $field->getName(),
                            $field->getAlias(),
                            [],
                            $field->getDirectives(),
                            $field->getLocation(),
                        );
                    },
                    $fields
                )
            ));
            $fieldDirectiveResolverInstances = $relationalTypeResolver->getDirectiveResolverInstancesForDirective(
                $this->directive,
                $fieldDirectiveFields,
                $variables
            );
            // Nothing to do, there's some error
            if ($fieldDirectiveResolverInstances === null) {
                return;
            }
            // Consolidate the same directiveResolverInstances for different fields, as to execute them only once
            $directiveResolverInstanceFieldsDataItems = [];
            foreach ($fieldDirectiveResolverInstances as $field) {
                $directiveResolverInstance = $fieldDirectiveResolverInstances[$field];
                $instanceID = get_class($directiveResolverInstance);
                if (!isset($directiveResolverInstanceFieldsDataItems[$instanceID])) {
                    $directiveResolverInstanceFieldsDataItems[$instanceID]['instance'] = $directiveResolverInstance;
                }
                $directiveResolverInstanceFieldsDataItems[$instanceID]['fields'][] = $field;
            }
            // Iterate through all the directives, and simply resolve each
            foreach ($directiveResolverInstanceFieldsDataItems as $instanceID => $directiveResolverInstanceFieldsDataItem) {
                /** @var DirectiveResolverInterface */
                $directiveResolverInstance = $directiveResolverInstanceFieldsDataItem['instance'];
                /** @var FieldInterface[] */
                $directiveResolverFields = $directiveResolverInstanceFieldsDataItem['fields'];

                // Regenerate the $idFieldSet for each directive
                /** @var array<string|int,EngineIterationFieldSet> */
                $directiveResolverIDFieldSet = [];
                foreach (array_keys($idFieldSet) as $id) {
                    $directiveResolverIDFieldSet[$id] = new EngineIterationFieldSet($directiveResolverFields);
                }
                $directiveResolverInstance->resolveDirective(
                    $relationalTypeResolver,
                    $directiveResolverIDFieldSet,
                    $succeedingPipelineDirectiveResolverInstances,
                    $objectIDItems,
                    $unionDBKeyIDs,
                    $previousDBItems,
                    $succeedingPipelineIDFieldSet,
                    $dbItems,
                    $variables,
                    $messages,
                    $engineIterationFeedbackStore,
                );
            }
            // That's it, we are done!
            return;
        }

        // Otherwise, let the parent process it
        parent::resolveDirective(
            $relationalTypeResolver,
            $idFieldSet,
            $succeedingPipelineDirectiveResolverInstances,
            $objectIDItems,
            $unionDBKeyIDs,
            $previousDBItems,
            $succeedingPipelineIDFieldSet,
            $dbItems,
            $variables,
            $messages,
            $engineIterationFeedbackStore,
        );
    }
}
