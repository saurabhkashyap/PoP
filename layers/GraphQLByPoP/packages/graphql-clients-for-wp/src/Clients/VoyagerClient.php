<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLClientsForWP\Clients;

use PoP\Root\App;
use GraphQLByPoP\GraphQLClientsForWP\Module;
use GraphQLByPoP\GraphQLClientsForWP\ModuleConfiguration;

class VoyagerClient extends AbstractClient
{
    /**
     * Indicate if the client is disabled
     */
    protected function isClientDisabled(): bool
    {
        /** @var ModuleConfiguration */
        $componentConfiguration = App::getComponent(Module::class)->getConfiguration();
        return $componentConfiguration->isVoyagerClientEndpointDisabled();
    }
    public function getEndpoint(): string
    {
        /** @var ModuleConfiguration */
        $componentConfiguration = App::getComponent(Module::class)->getConfiguration();
        return $componentConfiguration->getVoyagerClientEndpoint();
    }
    protected function getClientRelativePath(): string
    {
        return '/clients/voyager';
    }
    protected function getJSFilename(): string
    {
        return 'voyager.js';
    }
}
