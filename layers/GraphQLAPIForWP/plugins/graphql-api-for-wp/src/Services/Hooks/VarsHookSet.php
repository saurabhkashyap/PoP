<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Hooks;

use GraphQLAPI\GraphQLAPI\ModuleResolvers\EndpointFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\Registries\ModuleRegistryInterface;
use PoP\API\Response\Schemes as APISchemes;
use PoP\GraphQLAPI\DataStructureFormatters\GraphQLDataStructureFormatter;
use PoP\Hooks\AbstractHookSet;
use Symfony\Contracts\Service\Attribute\Required;

class VarsHookSet extends AbstractHookSet
{
    protected ?ModuleRegistryInterface $moduleRegistry = null;
    protected ?GraphQLDataStructureFormatter $graphQLDataStructureFormatter = null;

    public function setModuleRegistry(ModuleRegistryInterface $moduleRegistry): void
    {
        $this->moduleRegistry = $moduleRegistry;
    }
    protected function getModuleRegistry(): ModuleRegistryInterface
    {
        return $this->moduleRegistry ??= $this->instanceManager->getInstance(ModuleRegistryInterface::class);
    }
    public function setGraphQLDataStructureFormatter(GraphQLDataStructureFormatter $graphQLDataStructureFormatter): void
    {
        $this->graphQLDataStructureFormatter = $graphQLDataStructureFormatter;
    }
    protected function getGraphQLDataStructureFormatter(): GraphQLDataStructureFormatter
    {
        return $this->graphQLDataStructureFormatter ??= $this->instanceManager->getInstance(GraphQLDataStructureFormatter::class);
    }

    //#[Required]
    final public function autowireVarsHookSet(
        ModuleRegistryInterface $moduleRegistry,
        GraphQLDataStructureFormatter $graphQLDataStructureFormatter,
    ): void {
        $this->moduleRegistry = $moduleRegistry;
        $this->graphQLDataStructureFormatter = $graphQLDataStructureFormatter;
    }

    protected function init(): void
    {
        // Implement immediately, before VarsHookSet in API adds output=json
        $this->getHooksAPI()->addAction(
            'ApplicationState:addVars',
            array($this, 'maybeRemoveVars'),
            0,
            1
        );
    }

    /**
     * If the single endpoint is disabled, or if pointing to a different URL
     * than the single endpoint (eg: /posts/) and the datastructure param
     * is not provided it's not "graphql", then:
     * Do not allow to query the endpoint through URL.
     *
     * Examples of not allowed URLs:
     * - /single-endpoint/?scheme=api&datastructure=graphql <= single endpoint disabled
     * - /posts/?scheme=api
     *
     * @param array<array> $vars_in_array
     */
    public function maybeRemoveVars(array $vars_in_array): void
    {
        [&$vars] = $vars_in_array;
        if (isset($vars['scheme']) && $vars['scheme'] == APISchemes::API) {
            // By setting explicit allowed datastructures, we avoid the empty one
            // being processed /?scheme=api <= native API
            // If ever need to support REST or another format, add a hook here
            $allowedDataStructures = [
                $this->getGraphQLDataStructureFormatter()->getName(),
            ];
            if (
                // If single endpoint not enabled
                !$this->getModuleRegistry()->isModuleEnabled(EndpointFunctionalityModuleResolver::SINGLE_ENDPOINT)
                // If datastructure is not GraphQL (or another allowed one)
                || !in_array($vars['datastructure'], $allowedDataStructures)
            ) {
                unset($vars['scheme']);
                unset($vars['datastructure']);
            }
        }
    }
}
