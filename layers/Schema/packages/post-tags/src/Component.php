<?php

declare(strict_types=1);

namespace PoPSchema\PostTags;

use PoP\Root\Component\AbstractComponent;
use PoP\Routing\DefinitionGroups;
use PoP\Definitions\Facades\DefinitionManagerFacade;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    /**
     * Classes from PoP components that must be initialized before this component
     *
     * @return string[]
     */
    public static function getDependedComponentClasses(): array
    {
        return [
            \PoPSchema\Posts\Component::class,
            \PoPSchema\Tags\Component::class,
        ];
    }

    /**
     * All conditional component classes that this component depends upon, to initialize them
     */
    public static function getDependedConditionalComponentClasses(): array
    {
        return [
            \PoP\API\Component::class,
            \PoP\RESTAPI\Component::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param array<string, mixed> $configuration
     * @param string[] $skipSchemaComponentClasses
     */
    protected static function initializeContainerServices(
        array $configuration = [],
        bool $skipSchema = false,
        array $skipSchemaComponentClasses = []
    ): void {
        ComponentConfiguration::setConfiguration($configuration);
        self::initServices(dirname(__DIR__));
        self::initSchemaServices(dirname(__DIR__), $skipSchema);
        if (class_exists('\PoP\API\Component') && \PoP\API\Component::isEnabled()) {
            self::initServices(dirname(__DIR__), '/Conditional/API');
        }
        if (class_exists('\PoP\RESTAPI\Component') && \PoP\RESTAPI\Component::isEnabled()) {
            self::initServices(dirname(__DIR__), '/Conditional/RESTAPI');
        }
    }

    /**
     * Define runtime constants
     */
    protected static function defineRuntimeConstants(
        array $configuration = [],
        bool $skipSchema = false,
        array $skipSchemaComponentClasses = []
    ): void {
        if (!defined('POP_POSTTAGS_ROUTE_POSTTAGS')) {
            $definitionManager = DefinitionManagerFacade::getInstance();
            define('POP_POSTTAGS_ROUTE_POSTTAGS', $definitionManager->getUniqueDefinition('post-tags', DefinitionGroups::ROUTES));
        }
    }
}
