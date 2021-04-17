<?php

declare(strict_types=1);

namespace GraphQLAPI\EventsManager\ModuleResolvers;

use GraphQLAPI\EventsManager\GraphQLAPIExtension;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\SchemaTypeModuleResolver;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\AbstractSchemaTypeModuleResolver;

class SchemaModuleResolver extends AbstractSchemaTypeModuleResolver
{
    use ModuleResolverTrait;

    public const SCHEMA_EVENTS = GraphQLAPIExtension::NAMESPACE . '\schema-events';

    public function getModulesToResolve(): array
    {
        return [
            self::SCHEMA_EVENTS,
        ];
    }

    public function areRequirementsSatisfied(string $module): bool
    {
        switch ($module) {
            case self::SCHEMA_EVENTS:
                /**
                 * Events Manager plugin must be installed and active
                 */
                return defined('EM_VERSION');
        }
        return parent::areRequirementsSatisfied($module);
    }

    public function getDependedModuleLists(string $module): array
    {
        switch ($module) {
            case self::SCHEMA_EVENTS:
                return [
                    [
                        SchemaTypeModuleResolver::SCHEMA_CUSTOMPOSTS,
                    ],
                ];
        }
        return parent::getDependedModuleLists($module);
    }

    public function getName(string $module): string
    {
        $names = [
            self::SCHEMA_EVENTS => \__('Schema Events', 'graphql-api-events-manager'),
        ];
        return $names[$module] ?? $module;
    }

    public function getDescription(string $module): string
    {
        switch ($module) {
            case self::SCHEMA_EVENTS:
                return \__('Fetch event data from the Events Manager plugin. It requires this plugin to be activated', 'graphql-api-events-manager');
        }
        return parent::getDescription($module);
    }
}