<?php

declare(strict_types=1);

namespace PoP\Engine\DirectiveResolvers;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\TypeResolvers\PipelinePositions;
use PoP\ComponentModel\TypeResolvers\Object\ObjectTypeResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\AbstractGlobalDirectiveResolver;

class IncludeDirectiveResolver extends AbstractGlobalDirectiveResolver
{
    use FilterIDsSatisfyingConditionDirectiveResolverTrait;

    public function getDirectiveName(): string
    {
        return 'include';
    }

    /**
     * Place it after the validation and before it's added to $dbItems in the resolveAndMerge directive
     */
    public function getPipelinePosition(): string
    {
        return PipelinePositions::AFTER_VALIDATE_BEFORE_RESOLVE;
    }

    public function resolveDirective(
        ObjectTypeResolverInterface $objectTypeResolver,
        array &$idsDataFields,
        array &$succeedingPipelineIDsDataFields,
        array &$succeedingPipelineDirectiveResolverInstances,
        array &$resultIDItems,
        array &$unionDBKeyIDs,
        array &$dbItems,
        array &$previousDBItems,
        array &$variables,
        array &$messages,
        array &$dbErrors,
        array &$dbWarnings,
        array &$dbDeprecations,
        array &$dbNotices,
        array &$dbTraces,
        array &$schemaErrors,
        array &$schemaWarnings,
        array &$schemaDeprecations,
        array &$schemaNotices,
        array &$schemaTraces
    ): void {
        // Check the condition field. If it is satisfied, then keep those fields, otherwise remove them from the $idsDataFields in the upcoming stages of the pipeline
        $includeDataFieldsForIds = $this->getIdsSatisfyingCondition($objectTypeResolver, $resultIDItems, $idsDataFields, $variables, $messages, $dbErrors, $dbWarnings, $dbDeprecations);
        $idsToRemove = array_diff(array_keys($idsDataFields), $includeDataFieldsForIds);
        $this->removeDataFieldsForIDs($idsDataFields, $idsToRemove, $succeedingPipelineIDsDataFields);
    }
    public function getSchemaDirectiveDescription(ObjectTypeResolverInterface $objectTypeResolver): ?string
    {
        return $this->translationAPI->__('Include the field value in the output only if the argument \'if\' evals to `true`', 'api');
    }
    public function getSchemaDirectiveArgs(ObjectTypeResolverInterface $objectTypeResolver): array
    {
        return [
            [
                SchemaDefinition::ARGNAME_NAME => 'if',
                SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_BOOL,
                SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('Argument that must evaluate to `true` to include the field value in the output', 'api'),
                SchemaDefinition::ARGNAME_MANDATORY => true,
            ],
        ];
    }
}
