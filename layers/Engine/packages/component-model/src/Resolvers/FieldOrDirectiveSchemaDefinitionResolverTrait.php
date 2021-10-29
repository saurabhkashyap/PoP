<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Resolvers;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\DangerouslyDynamicScalarTypeResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait FieldOrDirectiveSchemaDefinitionResolverTrait
{
    protected ?DangerouslyDynamicScalarTypeResolver $dangerouslyDynamicScalarTypeResolver = null;

    public function setDangerouslyDynamicScalarTypeResolver(DangerouslyDynamicScalarTypeResolver $dangerouslyDynamicScalarTypeResolver): void
    {
        $this->dangerouslyDynamicScalarTypeResolver = $dangerouslyDynamicScalarTypeResolver;
    }
    protected function getDangerouslyDynamicScalarTypeResolver(): DangerouslyDynamicScalarTypeResolver
    {
        return $this->dangerouslyDynamicScalarTypeResolver ??= $this->instanceManager->getInstance(DangerouslyDynamicScalarTypeResolver::class);
    }

    //#[Required]
    final public function autowireFieldOrDirectiveSchemaDefinitionResolverTrait(
        DangerouslyDynamicScalarTypeResolver $dangerouslyDynamicScalarTypeResolver,
    ): void {
        $this->dangerouslyDynamicScalarTypeResolver = $dangerouslyDynamicScalarTypeResolver;
    }

    final public function getFieldOrDirectiveArgTypeSchemaDefinition(
        string $argName,
        InputTypeResolverInterface $argInputTypeResolver,
        ?string $argDescription,
        mixed $argDefaultValue,
        int $argTypeModifiers,
    ): array {
        return $this->getTypeSchemaDefinition(
            $argName,
            $argInputTypeResolver,
            $argDescription,
            $argDefaultValue,
            $argTypeModifiers,
            null
        );
    }

    final public function getFieldTypeSchemaDefinition(
        string $fieldName,
        ConcreteTypeResolverInterface $fieldTypeResolver,
        ?string $fieldDescription,
        int $fieldTypeModifiers,
        ?string $fieldDeprecationMessage,
    ): array {
        return $this->getTypeSchemaDefinition(
            $fieldName,
            $fieldTypeResolver,
            $fieldDescription,
            null,
            $fieldTypeModifiers,
            $fieldDeprecationMessage,
        );
    }

    final public function getTypeSchemaDefinition(
        string $name,
        TypeResolverInterface $typeResolver,
        ?string $description,
        mixed $defaultValue,
        int $typeModifiers,
        ?string $deprecationMessage,
    ): array {
        $schemaDefinition = [
            SchemaDefinition::NAME => $name,
            SchemaDefinition::TYPE_RESOLVER => $typeResolver,
        ];
        if ($description !== null) {
            $schemaDefinition[SchemaDefinition::DESCRIPTION] = $description;
        }
        if ($defaultValue !== null) {
            $schemaDefinition[SchemaDefinition::DEFAULT_VALUE] = $defaultValue;
        }
        if ($deprecationMessage !== null) {
            $schemaDefinition[SchemaDefinition::DEPRECATED] = true;
            $schemaDefinition[SchemaDefinition::DEPRECATION_MESSAGE] = $deprecationMessage;
        }
        $this->processSchemaDefinitionTypeModifiers(
            $schemaDefinition,
            $typeModifiers
        );
        return $schemaDefinition;
    }

    /**
     * Use bitwise operators to extract the applied modifiers
     *
     * @see https://www.php.net/manual/en/language.operators.bitwise.php#91291
     */
    private function processSchemaDefinitionTypeModifiers(
        array &$schemaDefinition,
        int $typeModifiers,
    ): void {
        // This value is valid for the field or directive arg
        if ($typeModifiers & SchemaTypeModifiers::MANDATORY) {
            $schemaDefinition[SchemaDefinition::MANDATORY] = true;
        }

        // This value is valid for the field return value
        if ($typeModifiers & SchemaTypeModifiers::NON_NULLABLE) {
            $schemaDefinition[SchemaDefinition::NON_NULLABLE] = true;
        }

        // The values below are valid both for field, and field/directive args
        // If setting the "array of arrays" flag, there's no need to set the "array" flag
        $isArrayOfArrays = $typeModifiers & SchemaTypeModifiers::IS_ARRAY_OF_ARRAYS;
        if (
            $typeModifiers & SchemaTypeModifiers::IS_ARRAY
            || $isArrayOfArrays
        ) {
            $schemaDefinition[SchemaDefinition::IS_ARRAY] = true;
            if ($typeModifiers & SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY) {
                $schemaDefinition[SchemaDefinition::IS_NON_NULLABLE_ITEMS_IN_ARRAY] = true;
            }
            if ($isArrayOfArrays) {
                $schemaDefinition[SchemaDefinition::IS_ARRAY_OF_ARRAYS] = true;
                if ($typeModifiers & SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY_OF_ARRAYS) {
                    $schemaDefinition[SchemaDefinition::IS_NON_NULLABLE_ITEMS_IN_ARRAY_OF_ARRAYS] = true;
                }
            }
        }
    }

    /**
     * `DangerouslyDynamic` is a special scalar type which is not coerced or validated.
     * In particular, it does not need to validate if it is an array or not,
     * as according to the applied WrappingType.
     *
     * If disabled, then do not expose the field if either:
     *
     * 1. its type is `DangerouslyDynamic`
     * 2. it has any mandatory argument of type `DangerouslyDynamic`
     *
     * @param array<string, InputTypeResolverInterface> $consolidatedFieldArgNameTypeResolvers
     * @param array<string, int> $consolidatedFieldArgsTypeModifiers
     */
    protected function isDangerouslyDynamicScalarFieldType(
        TypeResolverInterface $fieldTypeResolver,
        array $consolidatedFieldArgNameTypeResolvers,
        array $consolidatedFieldArgsTypeModifiers,
    ): bool {
        // 1. its type is `DangerouslyDynamic`
        if ($fieldTypeResolver === $this->getDangerouslyDynamicScalarTypeResolver()) {
            return true;
        }

        // 2. it has any mandatory argument of type `DangerouslyDynamic`
        if (
            $this->hasMandatoryDangerouslyDynamicScalarInputType(
                $consolidatedFieldArgNameTypeResolvers,
                $consolidatedFieldArgsTypeModifiers,
            )
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param array<string, InputTypeResolverInterface> $consolidatedFieldOrDirectiveArgNameTypeResolvers
     * @param array<string, int> $consolidatedFieldOrDirectiveArgsTypeModifiers
     */
    protected function hasMandatoryDangerouslyDynamicScalarInputType(
        array $consolidatedFieldOrDirectiveArgNameTypeResolvers,
        array $consolidatedFieldOrDirectiveArgsTypeModifiers,
    ): bool {
        $dangerouslyDynamicFieldOrDirectiveArgNameTypeResolvers = array_filter(
            $consolidatedFieldOrDirectiveArgNameTypeResolvers,
            fn (InputTypeResolverInterface $inputTypeResolver) => $inputTypeResolver === $this->getDangerouslyDynamicScalarTypeResolver()
        );
        foreach (array_keys($dangerouslyDynamicFieldOrDirectiveArgNameTypeResolvers) as $fieldOrDirectiveArgName) {
            $consolidatedFieldOrDirectiveArgTypeModifiers = $consolidatedFieldOrDirectiveArgsTypeModifiers[$fieldOrDirectiveArgName];
            if ($consolidatedFieldOrDirectiveArgTypeModifiers & SchemaTypeModifiers::MANDATORY) {
                return true;
            }
        }

        return false;
    }
}
