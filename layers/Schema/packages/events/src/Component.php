<?php

declare(strict_types=1);

namespace PoPSchema\Events;

use PoP\Root\Component\AbstractComponent;

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
            \PoPSchema\CustomPosts\Component::class,
            \PoPSchema\Locations\Component::class,
        ];
    }

    /**
     * All conditional component classes that this component depends upon, to initialize them
     */
    public static function getDependedConditionalComponentClasses(): array
    {
        return [
            \PoPSchema\Users\Component::class,
            \PoPSchema\Tags\Component::class,
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

        if (class_exists('\PoPSchema\Tags\Component')) {
            self::initSchemaServices(
                dirname(__DIR__),
                $skipSchema || in_array(\PoPSchema\Tags\Component::class, $skipSchemaComponentClasses),
                '/Conditional/Tags'
            );
        }

        if (class_exists('\PoPSchema\Users\Component')) {
            self::initSchemaServices(
                dirname(__DIR__),
                $skipSchema || in_array(\PoPSchema\Users\Component::class, $skipSchemaComponentClasses),
                '/Conditional/Users'
            );
        }

        if (Environment::addEventTypeToCustomPostUnionTypes()) {
            self::initSchemaServices(dirname(__DIR__), $skipSchema, '/ConditionalOnEnvironment/AddEventTypeToCustomPostUnionTypes');
        }
    }
}
