<?php

declare(strict_types=1);

namespace PoP\Engine\DirectiveResolvers;

use PoP\ComponentModel\DirectiveResolvers\AbstractGlobalDirectiveResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\TypeResolvers\PipelinePositions;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\Engine\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class SkipDirectiveResolver extends AbstractGlobalDirectiveResolver
{
    use FilterIDsSatisfyingConditionDirectiveResolverTrait;

    protected BooleanScalarTypeResolver $booleanScalarTypeResolver;

    #[Required]
    public function autowireSkipDirectiveResolver(
        BooleanScalarTypeResolver $booleanScalarTypeResolver,
    ): void {
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }

    public function getDirectiveName(): string
    {
        return 'skip';
    }

    /**
     * Place it after the validation and before it's added to $dbItems in the resolveAndMerge directive
     */
    public function getPipelinePosition(): string
    {
        return PipelinePositions::AFTER_VALIDATE_BEFORE_RESOLVE;
    }

    public function resolveDirective(
        RelationalTypeResolverInterface $relationalTypeResolver,
        array &$idsDataFields,
        array &$succeedingPipelineIDsDataFields,
        array &$succeedingPipelineDirectiveResolverInstances,
        array &$objectIDItems,
        array &$unionDBKeyIDs,
        array &$dbItems,
        array &$previousDBItems,
        array &$variables,
        array &$messages,
        array &$objectErrors,
        array &$objectWarnings,
        array &$objectDeprecations,
        array &$objectNotices,
        array &$objectTraces,
        array &$schemaErrors,
        array &$schemaWarnings,
        array &$schemaDeprecations,
        array &$schemaNotices,
        array &$schemaTraces
    ): void {
        // Check the condition field. If it is satisfied, then skip those fields
        $idsToRemove = $this->getIdsSatisfyingCondition($relationalTypeResolver, $objectIDItems, $idsDataFields, $variables, $messages, $objectErrors, $objectWarnings, $objectDeprecations);
        $this->removeDataFieldsForIDs($idsDataFields, $idsToRemove, $succeedingPipelineIDsDataFields);
    }
    public function getSchemaDirectiveDescription(RelationalTypeResolverInterface $relationalTypeResolver): ?string
    {
        return $this->translationAPI->__('Include the field value in the output only if the argument \'if\' evals to `false`', 'engine');
    }
    public function getSchemaDirectiveArgNameResolvers(RelationalTypeResolverInterface $relationalTypeResolver): array
    {
        return [

        ];
    }

    public function getSchemaDirectiveArgDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $directiveArgName): ?string
    {
        return match ($directiveArgName) {
            default => parent::getSchemaDirectiveArgDescription($relationalTypeResolver, $directiveArgName),
        };
    }

    public function getSchemaDirectiveArgDefaultValue(RelationalTypeResolverInterface $relationalTypeResolver, string $directiveArgName): mixed
    {
        return match ($directiveArgName) {
            default => parent::getSchemaDirectiveArgDefaultValue($relationalTypeResolver, $directiveArgName),
        };
    }

    public function getSchemaDirectiveArgTypeModifiers(RelationalTypeResolverInterface $relationalTypeResolver, string $directiveArgName): ?int
    {
        return match ($directiveArgName) {
            default => parent::getSchemaDirectiveArgTypeModifiers($relationalTypeResolver, $directiveArgName),
        };
    }

    public function getSchemaDirectiveArgs(RelationalTypeResolverInterface $relationalTypeResolver): array
    {
        return [
            [
                SchemaDefinition::ARGNAME_NAME => 'if',
                SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_BOOL,
                SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('Argument that must evaluate to `false` to include the field value in the output', 'engine'),
                SchemaDefinition::ARGNAME_MANDATORY => true,
            ],
        ];
    }
}
