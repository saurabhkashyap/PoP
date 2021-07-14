<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\SchemaConfigurationExecuters;

use PoP\ComponentModel\Instances\InstanceManagerInterface;
use GraphQLAPI\GraphQLAPI\Registries\ModuleRegistryInterface;
use GraphQLAPI\GraphQLAPI\Services\Blocks\SchemaConfigCacheControlListBlock;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\PerformanceFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\Services\SchemaConfigurators\CacheControlGraphQLQueryConfigurator;

/**
 * It is applied only to PersistedQuery
 */
class CacheControlSchemaConfigurationExecuter extends AbstractSchemaConfigurationExecuter implements PersistedQuerySchemaConfigurationExecuterServiceTagInterface
{
    public function __construct(
        InstanceManagerInterface $instanceManager,
        ModuleRegistryInterface $moduleRegistry,
        protected CacheControlGraphQLQueryConfigurator $cacheControlGraphQLQueryConfigurator
    ) {
        parent::__construct(
            $instanceManager,
            $moduleRegistry,
        );
    }

    public function executeSchemaConfiguration(int $schemaConfigurationID): void
    {
        // Do not execute Cache Control when previewing the query
        if (\is_preview()) {
            return;
        }
        // Check it is enabled by module
        if (!$this->moduleRegistry->isModuleEnabled(PerformanceFunctionalityModuleResolver::CACHE_CONTROL)) {
            return;
        }

        $schemaConfigCCLBlockDataItem = $this->getSchemaConfigBlockDataItem($schemaConfigurationID);
        if (!is_null($schemaConfigCCLBlockDataItem)) {
            if ($cacheControlLists = $schemaConfigCCLBlockDataItem['attrs'][SchemaConfigCacheControlListBlock::ATTRIBUTE_NAME_CACHE_CONTROL_LISTS] ?? null) {
                foreach ($cacheControlLists as $cacheControlListID) {
                    $this->cacheControlGraphQLQueryConfigurator->executeSchemaConfiguration($cacheControlListID);
                }
            }
        }
    }

    protected function getBlockClass(): string
    {
        return SchemaConfigCacheControlListBlock::class;
    }
}
