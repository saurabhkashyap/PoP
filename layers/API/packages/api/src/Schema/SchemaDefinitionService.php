<?php

declare(strict_types=1);

namespace PoP\API\Schema;

use Exception;
use PoP\API\Cache\CacheTypes;
use PoP\API\ComponentConfiguration;
use PoP\API\PersistedQueries\PersistedFragmentManagerInterface;
use PoP\API\PersistedQueries\PersistedQueryManagerInterface;
use PoP\ComponentModel\Cache\PersistentCacheInterface;
use PoP\ComponentModel\Facades\Cache\PersistentCacheFacade;
use PoP\ComponentModel\TypeResolvers\EnumType\EnumTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InputObjectType\InputObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InterfaceType\InterfaceTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\ScalarTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\UnionType\UnionTypeResolverInterface;
use PoP\Engine\Cache\CacheUtils;
use PoP\Engine\Schema\SchemaDefinitionService as UpstreamSchemaDefinitionService;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class SchemaDefinitionService extends UpstreamSchemaDefinitionService implements SchemaDefinitionServiceInterface
{
    /**
     * Cannot autowire because its calling `getNamespace`
     * on services.yaml produces an exception of PHP properties not initialized
     * in its depended services.
     */
    protected ?PersistentCacheInterface $persistentCache = null;

    protected PersistedFragmentManagerInterface $fragmentCatalogueManager;
    protected PersistedQueryManagerInterface $queryCatalogueManager;
    protected RootObjectTypeResolver $rootObjectTypeResolver;

    #[Required]
    final public function autowireAPISchemaDefinitionService(
        PersistedFragmentManagerInterface $fragmentCatalogueManager,
        PersistedQueryManagerInterface $queryCatalogueManager,
        RootObjectTypeResolver $rootObjectTypeResolver,
    ): void {
        $this->fragmentCatalogueManager = $fragmentCatalogueManager;
        $this->queryCatalogueManager = $queryCatalogueManager;
        $this->rootObjectTypeResolver = $rootObjectTypeResolver;
    }

    final public function getPersistentCache(): PersistentCacheInterface
    {
        $this->persistentCache ??= PersistentCacheFacade::getInstance();
        return $this->persistentCache;
    }

    public function getFullSchemaDefinition(): array
    {
        // Attempt to retrieve from the cache, if enabled
        if ($useCache = ComponentConfiguration::useSchemaDefinitionCache()) {
            // Use different caches for the normal and namespaced schemas, or
            // it throws exception if switching without deleting the cache (eg: when passing ?use_namespace=1)
            $cacheType = CacheTypes::FULLSCHEMA_DEFINITION;
            $cacheKeyComponents = CacheUtils::getSchemaCacheKeyComponents();
            // For the persistentCache, use a hash to remove invalid characters (such as "()")
            $cacheKey = hash('md5', json_encode($cacheKeyComponents));
        }
        $schemaDefinition = null;
        if ($useCache) {
            if ($this->getPersistentCache()->hasCache($cacheKey, $cacheType)) {
                $schemaDefinition = $this->getPersistentCache()->getCache($cacheKey, $cacheType);
            }
        }
        if ($schemaDefinition === null) {
            $schemaDefinition = [];
            /**
             * Starting from the Root TypeResolver, iterate and get the
             * SchemaDefinition for all TypeResolvers accessed in the schema
             */
            $processedTypeResolverNames = [];
            /** @var TypeResolverInterface[] */
            $typeResolverStack = $this->getRootObjectTypeResolvers();
            while (!empty($typeResolverStack)) {
                $typeResolver = array_pop($typeResolverStack);
                $typeResolverName = $typeResolver->getMaybeNamespacedTypeName();
                $processedTypeResolverNames[] = $typeResolverName;
                // Place different types under different entries
                $stackMessages = [
                    'processed' => [],
                ];
                $generalMessages = [
                    'processed' => [],
                ];
                $typeResolverSchemaDefinition = $typeResolver->getSchemaDefinition($stackMessages, $generalMessages, []);
                if ($typeResolver instanceof ObjectTypeResolverInterface) {
                    $type = SchemaDefinition::TYPE_OBJECT;
                } elseif ($typeResolver instanceof InterfaceTypeResolverInterface) {
                    $type = SchemaDefinition::TYPE_INTERFACE;
                } elseif ($typeResolver instanceof UnionTypeResolverInterface) {
                    $type = SchemaDefinition::TYPE_UNION;
                } elseif ($typeResolver instanceof ScalarTypeResolverInterface) {
                    $type = SchemaDefinition::TYPE_SCALAR;
                } elseif ($typeResolver instanceof EnumTypeResolverInterface) {
                    $type = SchemaDefinition::TYPE_ENUM;
                } elseif ($typeResolver instanceof InputObjectTypeResolverInterface) {
                    $type = SchemaDefinition::TYPE_INPUT_OBJECT;
                } else {
                    throw new Exception(sprintf(
                        $this->translationAPI->__('No type identified for TypeResolver with class \'%s\'', 'api'),
                        get_class($typeResolver)
                    ));
                }
                $schemaDefinition[SchemaDefinition::TYPES][$type][$typeResolverName] = $typeResolverSchemaDefinition;
            }
            
            // $schemaDefinition[SchemaDefinition::TYPES] = $typeSchemaDefinition;

            // // Add the queryType
            // $schemaDefinition[SchemaDefinition::QUERY_TYPE] = $rootTypeSchemaKey;

            // // Move from under Root type to the top: globalDirectives and globalFields (renamed as "functions")
            // $schemaDefinition[SchemaDefinition::GLOBAL_FIELDS] = $typeSchemaDefinition[$rootTypeSchemaKey][SchemaDefinition::GLOBAL_FIELDS] ?? [];
            // $schemaDefinition[SchemaDefinition::GLOBAL_CONNECTIONS] = $typeSchemaDefinition[$rootTypeSchemaKey][SchemaDefinition::GLOBAL_CONNECTIONS] ?? [];
            // $schemaDefinition[SchemaDefinition::GLOBAL_DIRECTIVES] = $typeSchemaDefinition[$rootTypeSchemaKey][SchemaDefinition::GLOBAL_DIRECTIVES] ?? [];
            // unset($schemaDefinition[SchemaDefinition::TYPES][$rootTypeSchemaKey][SchemaDefinition::GLOBAL_FIELDS]);
            // unset($schemaDefinition[SchemaDefinition::TYPES][$rootTypeSchemaKey][SchemaDefinition::GLOBAL_CONNECTIONS]);
            // unset($schemaDefinition[SchemaDefinition::TYPES][$rootTypeSchemaKey][SchemaDefinition::GLOBAL_DIRECTIVES]);

            // // Remove the globals from the Root
            // unset($typeFlatList[$rootTypeSchemaKey][SchemaDefinition::GLOBAL_FIELDS]);
            // unset($typeFlatList[$rootTypeSchemaKey][SchemaDefinition::GLOBAL_CONNECTIONS]);
            // unset($typeFlatList[$rootTypeSchemaKey][SchemaDefinition::GLOBAL_DIRECTIVES]);

            // // Because they were added in reverse way, reverse it once again, so that the first types (eg: Root) appear first
            // $schemaDefinition[SchemaDefinition::TYPES] = array_reverse($typeFlatList);
            
            
            
            
            
            

            // Add the Fragment Catalogue
            $persistedFragments = $this->fragmentCatalogueManager->getPersistedFragmentsForSchema();
            $schemaDefinition[SchemaDefinition::PERSISTED_FRAGMENTS] = $persistedFragments;

            // Add the Query Catalogue
            $persistedQueries = $this->queryCatalogueManager->getPersistedQueriesForSchema();
            $schemaDefinition[SchemaDefinition::PERSISTED_QUERIES] = $persistedQueries;

            // Store in the cache
            if ($useCache) {
                $this->getPersistentCache()->storeCache($cacheKey, $cacheType, $schemaDefinition);
            }
        }

        return $schemaDefinition;
    }

    /**
     * @return ObjectTypeResolverInterface[]
     */
    protected function getRootObjectTypeResolvers(): array
    {
        return [
            $this->rootObjectTypeResolver,
        ];
    }
}
