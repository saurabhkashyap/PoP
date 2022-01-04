<?php

declare(strict_types=1);

namespace PoPSchema\CommentMutations;

use PoP\Root\Component\AbstractComponent;
use PoPSchema\Users\Component as UsersComponent;

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
    public function getDependedComponentClasses(): array
    {
        return [
            \PoPSchema\Comments\Component::class,
            \PoPSchema\UserStateMutations\Component::class,
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
        self::initServices(dirname(__DIR__));
        self::initSchemaServices(dirname(__DIR__), $skipSchema);
        self::initSchemaServices(
            dirname(__DIR__),
            $skipSchema || in_array(UsersComponent::class, $skipSchemaComponentClasses),
            '/ConditionalOnComponent/Users'
        );
    }
}
