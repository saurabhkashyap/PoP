<?php

declare(strict_types=1);

namespace PoP\ComponentModel\ComponentProcessors;

use PoP\Root\App;

trait DataloadComponentProcessorTrait
{
    use FormattableModuleTrait;

    public function getSubmodules(array $componentVariation): array
    {
        $ret = parent::getSubmodules($componentVariation);

        if ($filter_module = $this->getFilterSubmodule($componentVariation)) {
            $ret[] = $filter_module;
        }

        if ($inners = $this->getInnerSubmodules($componentVariation)) {
            $ret = array_merge(
                $ret,
                $inners
            );
        }

        return $ret;
    }

    protected function getInnerSubmodules(array $componentVariation): array
    {
        return array();
    }

    public function getFilterSubmodule(array $componentVariation): ?array
    {
        return null;
    }

    public function metaInitProps(array $componentVariation, array &$props)
    {
        /**
         * Allow to add more stuff
         */
        App::doAction(
            Constants::HOOK_DATALOAD_INIT_MODEL_PROPS,
            array(&$props),
            $componentVariation,
            $this
        );
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        $this->metaInitProps($componentVariation, $props);
        parent::initModelProps($componentVariation, $props);
    }

    public function startDataloadingSection(array $componentVariation): bool
    {
        return true;
    }
}
