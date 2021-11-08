<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Hooks;

use PoP\ComponentModel\MutationResolution\MutationResolutionManagerInterface;
use PoP\Hooks\AbstractHookSet;

class MutationResolutionManagerHookSet extends AbstractHookSet
{
    private ?MutationResolutionManagerInterface $mutationResolutionManager = null;

    final public function setMutationResolutionManager(MutationResolutionManagerInterface $mutationResolutionManager): void
    {
        $this->mutationResolutionManager = $mutationResolutionManager;
    }
    final protected function getMutationResolutionManager(): MutationResolutionManagerInterface
    {
        return $this->mutationResolutionManager ??= $this->instanceManager->getInstance(MutationResolutionManagerInterface::class);
    }

    protected function init(): void
    {
        $this->getHooksAPI()->addAction(
            'augmentVarsProperties',
            [$this, 'clearResults']
        );
    }

    public function clearResults(): void
    {
        // Only if the service has been initialized
        if ($this->mutationResolutionManager !== null) {
            $this->getMutationResolutionManager()->clearResults();
        }
    }
}