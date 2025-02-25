<?php

declare(strict_types=1);

namespace PoP\ComponentModel\DirectiveResolvers;

use PoP\ComponentModel\Container\ServiceTags\MandatoryDirectiveServiceTagInterface;
use PoP\ComponentModel\Directives\DirectiveKinds;
use PoP\ComponentModel\Feedback\EngineIterationFeedbackStore;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\PipelinePositions;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\UnionType\UnionTypeResolverInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface;

final class ValidateDirectiveResolver extends AbstractValidateDirectiveResolver implements MandatoryDirectiveServiceTagInterface
{
    public function getDirectiveName(): string
    {
        return 'validate';
    }

    /**
     * This is a system directive
     */
    public function getDirectiveKind(): string
    {
        return DirectiveKinds::SYSTEM;
    }

    /**
     * Execute only once
     */
    public function isRepeatable(): bool
    {
        return false;
    }

    /**
     * This directive must be the first one of the group at the middle
     */
    public function getPipelinePosition(): string
    {
        return PipelinePositions::AFTER_VALIDATE_BEFORE_RESOLVE;
    }

    /**
     * @param FieldInterface[] $fields
     * @param FieldInterface[] $failedFields
     */
    protected function validateFields(
        RelationalTypeResolverInterface $relationalTypeResolver,
        array $fields,
        array &$variables,
        EngineIterationFeedbackStore $engineIterationFeedbackStore,
        array &$failedFields,
    ): void {
        foreach ($fields as $field) {
            $objectTypeFieldResolutionFeedbackStore = new ObjectTypeFieldResolutionFeedbackStore();
            $this->validateField(
                $relationalTypeResolver,
                $field,
                $variables,
                $objectTypeFieldResolutionFeedbackStore
            );
            $engineIterationFeedbackStore->schemaFeedbackStore->incorporateFromObjectTypeFieldResolutionFeedbackStore(
                $objectTypeFieldResolutionFeedbackStore,
                $relationalTypeResolver,
                $field,
                $this->directive
            );
            if ($objectTypeFieldResolutionFeedbackStore->getErrors() !== []) {
                $failedFields[] = $field;
            }
        }
    }

    protected function validateField(
        RelationalTypeResolverInterface $relationalTypeResolver,
        FieldInterface $field,
        array &$variables,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        /**
         * Because the UnionTypeResolver doesn't know yet which TypeResolver will be used
         * (that depends on each object), it can't resolve this functionality
         */
        if ($relationalTypeResolver instanceof UnionTypeResolverInterface) {
            return;
        }

        /** @var ObjectTypeResolverInterface */
        $objectTypeResolver = $relationalTypeResolver;

        $objectTypeResolver->collectFieldValidationErrors($field, $variables, $objectTypeFieldResolutionFeedbackStore);
        // If there are errors, do not check warnings/deprecations for fear of producing some exception
        if ($objectTypeFieldResolutionFeedbackStore->getErrors() !== []) {
            return;
        }
        $objectTypeResolver->collectFieldValidationWarnings($field, $variables, $objectTypeFieldResolutionFeedbackStore);
        $objectTypeResolver->collectFieldDeprecations($field, $variables, $objectTypeFieldResolutionFeedbackStore);
    }

    public function getDirectiveDescription(RelationalTypeResolverInterface $relationalTypeResolver): ?string
    {
        return $this->__('It validates the field, filtering out those field arguments that raised a warning, or directly invalidating the field if any field argument raised an error. For instance, if a mandatory field argument is not provided, then it is an error and the field is invalidated and removed from the output; if a field argument can\'t be casted to its intended type, then it is a warning, the affected field argument is removed and the field is executed without it. This directive is already included by the engine, since its execution is mandatory', 'component-model');
    }
}
