<?php

declare(strict_types=1);

namespace PoP\Engine\ConditionalOnContext\Guzzle\SchemaServices\FieldResolvers\ObjectType;

use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractGlobalObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\GuzzleHelpers\GuzzleHelpers;

class OperatorGlobalObjectTypeFieldResolver extends AbstractGlobalObjectTypeFieldResolver
{
    public function getFieldNamesToResolve(): array
    {
        return [
            'getJSON',
            'getAsyncJSON',
        ];
    }

    public function getSchemaFieldType(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): string
    {
        $types = [
            'getJSON' => SchemaDefinition::TYPE_OBJECT,
            'getAsyncJSON' => SchemaDefinition::TYPE_OBJECT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($objectTypeResolver, $fieldName);
    }

    public function getSchemaFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?int
    {
        return match ($fieldName) {
            'getAsyncJSON' => SchemaTypeModifiers::IS_ARRAY,
            default => parent::getSchemaFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'getJSON' => $this->translationAPI->__('Retrieve data from URL and decode it as a JSON object', 'pop-component-model'),
            'getAsyncJSON' => $this->translationAPI->__('Retrieve data from multiple URL asynchronously, and decode each of them as a JSON object', 'pop-component-model'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($objectTypeResolver, $fieldName);
    }

    public function getSchemaFieldArgs(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        $schemaFieldArgs = parent::getSchemaFieldArgs($objectTypeResolver, $fieldName);
        switch ($fieldName) {
            case 'getJSON':
                return array_merge(
                    $schemaFieldArgs,
                    [
                        [
                            SchemaDefinition::ARGNAME_NAME => 'url',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_URL,
                            SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('The URL to request', 'pop-component-model'),
                            SchemaDefinition::ARGNAME_MANDATORY => true,
                        ],
                    ]
                );
            case 'getAsyncJSON':
                return array_merge(
                    $schemaFieldArgs,
                    [
                        [
                            SchemaDefinition::ARGNAME_NAME => 'urls',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_URL,
                            SchemaDefinition::ARGNAME_IS_ARRAY => true,
                            SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('The URLs to request, with format `key:value`, where the value is the URL, and the key, if provided, is the name where to store the JSON data in the result (if not provided, it is accessed under the corresponding numeric index)', 'pop-component-model'),
                            SchemaDefinition::ARGNAME_MANDATORY => true,
                        ],
                    ]
                );
        }

        return $schemaFieldArgs;
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        switch ($fieldName) {
            case 'getJSON':
                return GuzzleHelpers::requestJSON($fieldArgs['url'], [], 'GET');
            case 'getAsyncJSON':
                return GuzzleHelpers::requestAsyncJSON($fieldArgs['urls'], [], 'GET');
        }
        return parent::resolveValue($objectTypeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}