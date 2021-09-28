<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\SchemaConfiguratorExecuters;

use GraphQLAPI\GraphQLAPI\Services\CustomPostTypes\GraphQLCustomEndpointCustomPostType;
use GraphQLAPI\GraphQLAPI\Services\SchemaConfigurators\CustomEndpointSchemaConfigurator;
use GraphQLAPI\GraphQLAPI\Services\SchemaConfigurators\SchemaConfiguratorInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;

class CustomEndpointSchemaConfiguratorExecuter extends AbstractLoadingCPTSchemaConfiguratorExecuter
{
    protected CustomEndpointSchemaConfigurator $endpointSchemaConfigurator;
    protected GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType;
    public function __construct(
        InstanceManagerInterface $instanceManager,
        CustomEndpointSchemaConfigurator $endpointSchemaConfigurator,
        GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType,
    ) {
        $this->endpointSchemaConfigurator = $endpointSchemaConfigurator;
        $this->graphQLCustomEndpointCustomPostType = $graphQLCustomEndpointCustomPostType;
        parent::__construct(
            $instanceManager,
        );
    }

    protected function getCustomPostType(): string
    {
        return $this->graphQLCustomEndpointCustomPostType->getCustomPostType();
    }

    protected function getSchemaConfigurator(): SchemaConfiguratorInterface
    {
        return $this->endpointSchemaConfigurator;
    }
}
