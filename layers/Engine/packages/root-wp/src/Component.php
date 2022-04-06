<?php

declare(strict_types=1);

namespace PoP\RootWP;

use Brain\Cortex;
use PoP\Root\Component\AbstractComponent;
use PoP\Root\Environment;

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
            \PoP\Root\Component::class,
        ];
    }

    /**
     * Do not enable when running PHPUnit tests
     * (the needed methods, such as `__`, will be satisfied
     * somewhere else)
     */
    protected function resolveEnabled(): bool
    {
        return !Environment::isApplicationEnvironmentDevPHPUnit();
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
        $this->initServices(dirname(__DIR__), '', 'hybrid-services.yaml');
        $this->initServices(dirname(__DIR__));
    }

    /**
     * Initialize services for the system container
     */
    protected function initializeSystemContainerServices(): void
    {
        $this->initSystemServices(dirname(__DIR__), '', 'hybrid-services.yaml');
    }

    public function componentLoaded(): void
    {
       Cortex::boot();
    }
}
