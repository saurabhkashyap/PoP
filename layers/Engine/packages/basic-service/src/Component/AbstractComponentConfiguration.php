<?php

declare(strict_types=1);

namespace PoP\BasicService\Component;

use PoP\BasicService\Component\ComponentConfigurationHelpers;
use PoP\Hooks\Facades\SystemHooksAPIFacade;
use PoP\Root\Component\AbstractComponentConfiguration as UpstreamAbstractComponentConfiguration;
use PoP\Root\Helpers\ClassHelpers;

/**
 * Initialize component
 */
abstract class AbstractComponentConfiguration extends UpstreamAbstractComponentConfiguration implements ComponentConfigurationInterface
{
    protected function maybeInitializeConfigurationValue(
        string $envVariable,
        mixed $defaultValue = null,
        ?callable $callback = null
    ): void {
        // Initialized from configuration? Then use that one directly.
        if ($this->hasConfigurationValue($envVariable)) {
            return;
        }
        
        // Initialize via environment
        parent::maybeInitializeConfigurationValue($envVariable, $defaultValue, $callback);

        /**
         * Get the value via a hook.
         *
         * Important: it must use the Hooks service from the System Container,
         * and not the (Application) Container, because ComponentConfiguration::foo()
         * may be accessed when initializing (Application) container services
         * in `Component.initialize()`, so it must already be available by then
         */
        $hooksAPI = SystemHooksAPIFacade::getInstance();
        $class = $this->getComponentClass();
        $hookName = ComponentConfigurationHelpers::getHookName(
            $class,
            $envVariable
        );
        $this->configuration[$envVariable] = $hooksAPI->applyFilters(
            $hookName,
            $this->configuration[$envVariable],
            $class,
            $envVariable
        );
    }

    /**
     * Package's Component class, of type ComponentInterface.
     * By standard, it is "NamespaceOwner\Project\Component::class"
     */
    protected function getComponentClass(): string
    {
        $classNamespace = ClassHelpers::getClassPSR4Namespace(\get_called_class());
        return $classNamespace . '\\Component';
    }
}
