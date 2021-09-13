<?php

declare(strict_types=1);

namespace PoP\API\FieldResolvers\ObjectType;

use PoP\API\Cache\CacheTypes;
use PoP\Engine\Cache\CacheUtils;
use PoP\API\ComponentConfiguration;
use PoP\API\Enums\SchemaFieldShapeEnum;
use PoP\API\Facades\PersistedFragmentManagerFacade;
use PoP\API\Facades\PersistedQueryManagerFacade;
use PoP\API\Schema\SchemaDefinition;
use PoP\ComponentModel\Facades\Cache\PersistentCacheFacade;
use PoP\ComponentModel\Facades\Schema\SchemaDefinitionServiceFacade;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaHelpers;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;

class RootObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            RootObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'fullSchema',
        ];
    }

    public function getSchemaFieldType(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): string
    {
        return match ($fieldName) {
            'fullSchema' => SchemaDefinition::TYPE_OBJECT,
            default => parent::getSchemaFieldType($objectTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?int
    {
        return match ($fieldName) {
            'fullSchema' => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default => parent::getSchemaFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'fullSchema' => $this->translationAPI->__('The whole API schema, exposing what fields can be queried', 'api'),
            default => parent::getSchemaFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldArgs(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        $schemaFieldArgs = parent::getSchemaFieldArgs($objectTypeResolver, $fieldName);
        switch ($fieldName) {
            case 'fullSchema':
                /**
                 * @var SchemaFieldShapeEnum
                 */
                $schemaOutputShapeEnum = $this->instanceManager->getInstance(SchemaFieldShapeEnum::class);
                return array_merge(
                    $schemaFieldArgs,
                    [
                        [
                            SchemaDefinition::ARGNAME_NAME => 'deep',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_BOOL,
                            SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('Make a deep introspection of the fields, for all nested objects', 'api'),
                            SchemaDefinition::ARGNAME_DEFAULT_VALUE => true,
                        ],
                        [
                            SchemaDefinition::ARGNAME_NAME => 'shape',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_ENUM,
                            SchemaDefinition::ARGNAME_DESCRIPTION => sprintf(
                                $this->translationAPI->__('How to shape the schema output: \'%s\', in which case all types are listed together, or \'%s\', in which the types are listed following where they appear in the graph', 'api'),
                                SchemaDefinition::ARGVALUE_SCHEMA_SHAPE_FLAT,
                                SchemaDefinition::ARGVALUE_SCHEMA_SHAPE_NESTED
                            ),
                            SchemaDefinition::ARGNAME_ENUM_NAME => $schemaOutputShapeEnum->getName(),
                            SchemaDefinition::ARGNAME_ENUM_VALUES => SchemaHelpers::convertToSchemaFieldArgEnumValueDefinitions(
                                $schemaOutputShapeEnum->getValues()
                            ),
                            SchemaDefinition::ARGNAME_DEFAULT_VALUE => SchemaDefinition::ARGVALUE_SCHEMA_SHAPE_FLAT,
                        ],
                        [
                            SchemaDefinition::ARGNAME_NAME => 'compressed',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_BOOL,
                            SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('Output each resolver\'s schema data only once to compress the output. Valid only when field \'deep\' is `true`', 'api'),
                            SchemaDefinition::ARGNAME_DEFAULT_VALUE => false,
                        ],
                        [
                            SchemaDefinition::ARGNAME_NAME => 'useTypeName',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_BOOL,
                            SchemaDefinition::ARGNAME_DESCRIPTION => sprintf(
                                $this->translationAPI->__('Replace type \'%s\' with the actual type name (such as \'Post\')', 'api'),
                                SchemaDefinition::TYPE_ID
                            ),
                            SchemaDefinition::ARGNAME_DEFAULT_VALUE => true,
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
        $root = $resultItem;
        switch ($fieldName) {
            case 'fullSchema':
                // Attempt to retrieve from the cache, if enabled
                if ($useCache = ComponentConfiguration::useSchemaDefinitionCache()) {
                    $persistentCache = PersistentCacheFacade::getInstance();
                    // Use different caches for the normal and namespaced schemas, or
                    // it throws exception if switching without deleting the cache (eg: when passing ?use_namespace=1)
                    $cacheType = CacheTypes::FULLSCHEMA_DEFINITION;
                    $cacheKeyComponents = CacheUtils::getSchemaCacheKeyComponents();
                    // For the persistentCache, use a hash to remove invalid characters (such as "()")
                    $cacheKey = hash('md5', json_encode($cacheKeyComponents));
                }
                $schemaDefinition = null;
                if ($useCache) {
                    if ($persistentCache->hasCache($cacheKey, $cacheType)) {
                        $schemaDefinition = $persistentCache->getCache($cacheKey, $cacheType);
                    }
                }
                if ($schemaDefinition === null) {
                    $schemaDefinitionService = SchemaDefinitionServiceFacade::getInstance();
                    $stackMessages = [
                        'processed' => [],
                    ];
                    $generalMessages = [
                        'processed' => [],
                    ];
                    $rootTypeSchemaKey = $schemaDefinitionService->getTypeSchemaKey($objectTypeResolver);
                    // Normalize properties in $fieldArgs with their defaults
                    // By default make it deep. To avoid it, must pass argument (deep:false)
                    // By default, use the "flat" shape
                    $schemaOptions = array_merge(
                        $options,
                        [
                            'deep' => $fieldArgs['deep'],
                            'compressed' => $fieldArgs['compressed'],
                            'shape' => $fieldArgs['shape'],
                            'useTypeName' => $fieldArgs['useTypeName'],
                        ]
                    );
                    // If it is flat shape, all types will be added under $generalMessages
                    $isFlatShape = $schemaOptions['shape'] == SchemaDefinition::ARGVALUE_SCHEMA_SHAPE_FLAT;
                    if ($isFlatShape) {
                        $generalMessages[SchemaDefinition::ARGNAME_TYPES] = [];
                    }
                    $typeSchemaDefinition = $objectTypeResolver->getSchemaDefinition($stackMessages, $generalMessages, $schemaOptions);
                    $schemaDefinition[SchemaDefinition::ARGNAME_TYPES] = $typeSchemaDefinition;

                    // Add the queryType
                    $schemaDefinition[SchemaDefinition::ARGNAME_QUERY_TYPE] = $rootTypeSchemaKey;

                    // Move from under Root type to the top: globalDirectives and globalFields (renamed as "functions")
                    $schemaDefinition[SchemaDefinition::ARGNAME_GLOBAL_FIELDS] = $typeSchemaDefinition[$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_FIELDS] ?? [];
                    $schemaDefinition[SchemaDefinition::ARGNAME_GLOBAL_CONNECTIONS] = $typeSchemaDefinition[$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_CONNECTIONS] ?? [];
                    $schemaDefinition[SchemaDefinition::ARGNAME_GLOBAL_DIRECTIVES] = $typeSchemaDefinition[$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_DIRECTIVES] ?? [];
                    unset($schemaDefinition[SchemaDefinition::ARGNAME_TYPES][$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_FIELDS]);
                    unset($schemaDefinition[SchemaDefinition::ARGNAME_TYPES][$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_CONNECTIONS]);
                    unset($schemaDefinition[SchemaDefinition::ARGNAME_TYPES][$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_DIRECTIVES]);

                    // Retrieve the list of all types from under $generalMessages
                    if ($isFlatShape) {
                        $typeFlatList = $generalMessages[SchemaDefinition::ARGNAME_TYPES];

                        // Remove the globals from the Root
                        unset($typeFlatList[$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_FIELDS]);
                        unset($typeFlatList[$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_CONNECTIONS]);
                        unset($typeFlatList[$rootTypeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_DIRECTIVES]);

                        // Because they were added in reverse way, reverse it once again, so that the first types (eg: Root) appear first
                        $schemaDefinition[SchemaDefinition::ARGNAME_TYPES] = array_reverse($typeFlatList);

                        // Add the interfaces to the root
                        $interfaces = [];
                        foreach ($schemaDefinition[SchemaDefinition::ARGNAME_TYPES] as $typeName => $typeDefinition) {
                            if ($typeInterfaces = $typeDefinition[SchemaDefinition::ARGNAME_INTERFACES] ?? null) {
                                $interfaces = array_merge(
                                    $interfaces,
                                    (array)$typeInterfaces
                                );
                                // Keep only the name of the interface under the type
                                $schemaDefinition[SchemaDefinition::ARGNAME_TYPES][$typeName][SchemaDefinition::ARGNAME_INTERFACES] = array_keys((array)$schemaDefinition[SchemaDefinition::ARGNAME_TYPES][$typeName][SchemaDefinition::ARGNAME_INTERFACES]);
                            }
                        }
                        $schemaDefinition[SchemaDefinition::ARGNAME_INTERFACES] = $interfaces;
                    }

                    // Add the Fragment Catalogue
                    $fragmentCatalogueManager = PersistedFragmentManagerFacade::getInstance();
                    $persistedFragments = $fragmentCatalogueManager->getPersistedFragmentsForSchema();
                    $schemaDefinition[SchemaDefinition::ARGNAME_PERSISTED_FRAGMENTS] = $persistedFragments;

                    // Add the Query Catalogue
                    $queryCatalogueManager = PersistedQueryManagerFacade::getInstance();
                    $persistedQueries = $queryCatalogueManager->getPersistedQueriesForSchema();
                    $schemaDefinition[SchemaDefinition::ARGNAME_PERSISTED_QUERIES] = $persistedQueries;

                    // Store in the cache
                    if ($useCache) {
                        $persistentCache->storeCache($cacheKey, $cacheType, $schemaDefinition);
                    }
                }

                return $schemaDefinition;
        }

        return parent::resolveValue($objectTypeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}