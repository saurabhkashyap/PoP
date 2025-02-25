<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\SchemaConfigurators;

use GraphQLAPI\GraphQLAPI\ModuleResolvers\EndpointFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\Registries\PersistedQueryEndpointSchemaConfigurationExecuterRegistryInterface;
use GraphQLAPI\GraphQLAPI\Registries\SchemaConfigurationExecuterRegistryInterface;

class PersistedQueryEndpointSchemaConfigurator extends AbstractCustomPostEndpointSchemaConfigurator
{
    private ?PersistedQueryEndpointSchemaConfigurationExecuterRegistryInterface $persistedQueryEndpointSchemaConfigurationExecuterRegistry = null;

    final public function setPersistedQueryEndpointSchemaConfigurationExecuterRegistry(PersistedQueryEndpointSchemaConfigurationExecuterRegistryInterface $persistedQueryEndpointSchemaConfigurationExecuterRegistry): void
    {
        $this->persistedQueryEndpointSchemaConfigurationExecuterRegistry = $persistedQueryEndpointSchemaConfigurationExecuterRegistry;
    }
    final protected function getPersistedQueryEndpointSchemaConfigurationExecuterRegistry(): PersistedQueryEndpointSchemaConfigurationExecuterRegistryInterface
    {
        return $this->persistedQueryEndpointSchemaConfigurationExecuterRegistry ??= $this->instanceManager->getInstance(PersistedQueryEndpointSchemaConfigurationExecuterRegistryInterface::class);
    }

    /**
     * Only enable the service, if the corresponding module is also enabled
     */
    public function isServiceEnabled(): bool
    {
        return $this->getModuleRegistry()->isModuleEnabled(EndpointFunctionalityModuleResolver::PERSISTED_QUERIES)
            && parent::isServiceEnabled();
    }

    protected function getSchemaConfigurationExecuterRegistry(): SchemaConfigurationExecuterRegistryInterface
    {
        return $this->getPersistedQueryEndpointSchemaConfigurationExecuterRegistry();
    }
}
