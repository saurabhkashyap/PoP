<?php

use PoP\ComponentModel\GraphQLEngine\Model\ComponentModelSpec\RelationalModuleField;

abstract class PoP_Module_Processor_PreloadTargetDataButtonsBase extends PoP_Module_Processor_ButtonsBase
{
    public function getTargetDynamicallyRenderedSubmodules(array $componentVariation)
    {
        return array();
    }

    /**
     * @return RelationalModuleField[]
     */
    public function getTargetDynamicallyRenderedSubcomponentSubmodules(array $componentVariation)
    {
        return array();
    }

    /**
     * @return RelationalModuleField[]
     */
    public function getRelationalSubmodules(array $componentVariation): array
    {
        $ret = parent::getRelationalSubmodules($componentVariation);

        // We need to load the data needed by the datum, so that when executing `triggerSelect` in function `renderDBObjectLayoutFromURLParam`
        // the data has already been preloaded
        if ($dynamic_modules = $this->getTargetDynamicallyRenderedSubcomponentSubmodules($componentVariation)) {
            $ret = array_merge(
                $ret,
                $dynamic_modules
            );
        }

        return $ret;
    }

    public function getSubComponentVariations(array $componentVariation): array
    {
        $ret = parent::getSubComponentVariations($componentVariation);

        // We need to load the data needed by the datum, so that when executing `triggerSelect` in function `renderDBObjectLayoutFromURLParam`
        // the data has already been preloaded
        if ($dynamic_modules = $this->getTargetDynamicallyRenderedSubmodules($componentVariation)) {
            $ret = array_merge(
                $ret,
                $dynamic_modules
            );
        }

        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {

        // Mark the layouts as needing dynamic data, so the DB data is sent to the webplatform also when doing SSR
        if (defined('POP_SSR_INITIALIZED')) {
            if ($dynamic_modules = $this->getTargetDynamicallyRenderedSubmodules($componentVariation)) {
                foreach ($dynamic_modules as $dynamic_module) {
                    $this->setProp($dynamic_module, $props, 'needs-dynamic-data', true);
                }
            }

            if ($subcomponent_dynamic_templates = $this->getTargetDynamicallyRenderedSubcomponentSubmodules($componentVariation)) {
                foreach ($subcomponent_dynamic_templates as $data_field => $modules) {
                    foreach ($modules as $dynamic_module) {
                        $this->setProp($dynamic_module, $props, 'needs-dynamic-data', true);
                    }
                }
            }
        }

        parent::initModelProps($componentVariation, $props);
    }
}
