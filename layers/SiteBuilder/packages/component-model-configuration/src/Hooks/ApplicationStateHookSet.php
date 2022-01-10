<?php

declare(strict_types=1);

namespace PoP\ConfigurationComponentModel\Hooks;

use PoP\BasicService\AbstractHookSet;
use PoP\ComponentModel\ModelInstance\ModelInstance;
use PoP\ComponentModel\State\ApplicationState;

class ApplicationStateHookSet extends AbstractHookSet
{
    protected function init(): void
    {
        $this->getHooksAPI()->addFilter(
            ModelInstance::HOOK_COMPONENTSFROMVARS_RESULT,
            [$this, 'maybeAddComponent']
        );
    }

    public function maybeAddComponent(array $components): array
    {
        if ($target = \PoP\Root\App::getState('target')) {
            $components[] = $this->__('target:', 'component-model') . $target;
        }
        if ($format = \PoP\Root\App::getState('format')) {
            $components[] = $this->__('format:', 'component-model') . $format;
        }

        return $components;
    }
}
