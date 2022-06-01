<?php

declare(strict_types=1);

namespace PoP\ComponentModel\ComponentFilters;

use PoP\ComponentModel\Component\Component;
use PoP\ComponentModel\ComponentProcessors\ComponentProcessorManagerInterface;
use PoP\Root\Services\BasicServiceTrait;

abstract class AbstractComponentFilter implements ComponentFilterInterface
{
    use BasicServiceTrait;

    private ?ComponentProcessorManagerInterface $componentProcessorManager = null;

    final public function setComponentProcessorManager(ComponentProcessorManagerInterface $componentProcessorManager): void
    {
        $this->componentProcessorManager = $componentProcessorManager;
    }
    final protected function getComponentProcessorManager(): ComponentProcessorManagerInterface
    {
        return $this->componentProcessorManager ??= $this->instanceManager->getInstance(ComponentProcessorManagerInterface::class);
    }

    public function excludeSubcomponent(\PoP\ComponentModel\Component\Component $component, array &$props): bool
    {
        return false;
    }

    /**
     * @param Component[] $subcomponents
     * @return Component[]
     */
    public function removeExcludedSubcomponents(\PoP\ComponentModel\Component\Component $component, array $subcomponents): array
    {
        return $subcomponents;
    }

    public function prepareForPropagation(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
    }

    public function restoreFromPropagation(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
    }
}
