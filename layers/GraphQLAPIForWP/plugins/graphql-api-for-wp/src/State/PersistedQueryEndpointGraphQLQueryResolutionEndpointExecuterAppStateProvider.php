<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\State;

use GraphQLAPI\GraphQLAPI\Services\EndpointExecuters\EndpointExecuterInterface;
use GraphQLAPI\GraphQLAPI\Services\EndpointExecuters\PersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter;

class PersistedQueryEndpointGraphQLQueryResolutionEndpointExecuterAppStateProvider extends AbstractEndpointExecuterAppStateProvider
{
    private ?PersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter $persistedQueryEndpointGraphQLQueryResolutionEndpointExecuter = null;

    final public function setPersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter(PersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter $persistedQueryEndpointGraphQLQueryResolutionEndpointExecuter): void
    {
        $this->persistedQueryEndpointGraphQLQueryResolutionEndpointExecuter = $persistedQueryEndpointGraphQLQueryResolutionEndpointExecuter;
    }
    final protected function getPersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter(): PersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter
    {
        return $this->persistedQueryEndpointGraphQLQueryResolutionEndpointExecuter ??= $this->instanceManager->getInstance(PersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter::class);
    }

    protected function getEndpointExecuter(): EndpointExecuterInterface
    {
        return $this->getPersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter();
    }
}
