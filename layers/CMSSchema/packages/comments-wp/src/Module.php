<?php

declare(strict_types=1);

namespace PoPCMSSchema\CommentsWP;

use PoP\Root\Module\AbstractModule;
use PoPCMSSchema\Users\Module as UsersModule;

/**
 * Initialize component
 */
class Module extends AbstractModule
{
    /**
     * All component classes that this component satisfies
     *
     * @return string[]
     */
    public function getSatisfiedModuleClasses(): array
    {
        return [
            \PoPCMSSchema\Comments\Module::class,
        ];
    }

    /**
     * Classes from PoP components that must be initialized before this component
     *
     * @return string[]
     */
    public function getDependedComponentClasses(): array
    {
        return [
            \PoPCMSSchema\Comments\Module::class,
            \PoPCMSSchema\CustomPostsWP\Module::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param string[] $skipSchemaComponentClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema,
        array $skipSchemaComponentClasses,
    ): void {
        $this->initServices(dirname(__DIR__));

        if (class_exists(UsersModule::class)) {
            $this->initServices(
                dirname(__DIR__),
                '/ConditionalOnModule/Users'
            );
            $this->initSchemaServices(
                dirname(__DIR__),
                $skipSchema || in_array(UsersModule::class, $skipSchemaComponentClasses),
                '/ConditionalOnModule/Users'
            );
        }
    }
}
