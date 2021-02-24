<?php

declare(strict_types=1);

namespace GraphQLAPI\ConvertCaseDirectives;

use PoP\Root\Component\AbstractComponent;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    public static function getDependedComponentClasses(): array
    {
        return [
            \PoP\ConvertCaseDirectives\Component::class,
        ];
    }

    /**
     * Initialize services for the system container
     */
    protected static function initializeSystemContainerServices(): void
    {
        parent::initializeContainerServices($configuration);
        self::initYAMLSystemContainerServices(dirname(__DIR__));
    }
}
