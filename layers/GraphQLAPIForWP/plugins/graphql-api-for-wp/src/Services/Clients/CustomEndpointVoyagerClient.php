<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Clients;

use GraphQLAPI\GraphQLAPI\Services\CustomPostTypes\GraphQLCustomEndpointCustomPostType;
use GraphQLByPoP\GraphQLClientsForWP\Clients\VoyagerClient;
use PoP\ComponentModel\HelperServices\RequestHelperServiceInterface;

class CustomEndpointVoyagerClient extends VoyagerClient
{
    use CustomEndpointClientTrait;

    private ?GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType = null;
    private ?RequestHelperServiceInterface $requestHelperService = null;

    final public function setGraphQLCustomEndpointCustomPostType(GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType): void
    {
        $this->graphQLCustomEndpointCustomPostType = $graphQLCustomEndpointCustomPostType;
    }
    final protected function getGraphQLCustomEndpointCustomPostType(): GraphQLCustomEndpointCustomPostType
    {
        return $this->graphQLCustomEndpointCustomPostType ??= $this->instanceManager->getInstance(GraphQLCustomEndpointCustomPostType::class);
    }
    final public function setRequestHelperService(RequestHelperServiceInterface $requestHelperService): void
    {
        $this->requestHelperService = $requestHelperService;
    }
    final protected function getRequestHelperService(): RequestHelperServiceInterface
    {
        return $this->requestHelperService ??= $this->instanceManager->getInstance(RequestHelperServiceInterface::class);
    }
}
