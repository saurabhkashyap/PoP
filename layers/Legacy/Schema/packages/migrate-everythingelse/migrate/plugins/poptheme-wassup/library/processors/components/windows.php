<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade;

class PoP_Module_Processor_Windows extends PoP_Module_Processor_WindowBase
{
    public final const MODULE_WINDOW_ADDONS = 'window-addons';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_WINDOW_ADDONS],
        );
    }

    public function getSubComponentVariations(array $componentVariation): array
    {
        return array_merge(
            parent::getSubComponentVariations($componentVariation),
            $this->getInnerSubmodules($componentVariation)
        );
    }

    protected function getInnerSubmodules(array $componentVariation): array
    {
        $pop_module_componentroutingprocessor_manager = ComponentRoutingProcessorManagerFacade::getInstance();

        switch ($componentVariation[1]) {
            case self::MODULE_WINDOW_ADDONS:
                $load_module = true;
                if (PoPThemeWassup_Utils::checkLoadingPagesectionModule()) {
                    $load_module = $componentVariation == $pop_module_componentroutingprocessor_manager->getRoutingComponentByMostAllMatchingStateProperties(POP_PAGEMODULEGROUP_TOPLEVEL_CONTENTPAGESECTION);
                }

                $addons_module = [PoP_Module_Processor_TabPanes::class, PoP_Module_Processor_TabPanes::MODULE_PAGESECTION_ADDONS];
                $addontabs_module = [PoP_Module_Processor_PageSections::class, PoP_Module_Processor_PageSections::MODULE_PAGESECTION_ADDONTABS];
                if ($load_module) {
                    return array(
                        $addons_module,
                        $addontabs_module,
                    );
                }

                // Tell the pageSections to have no pages inside
                $moduleAtts = array('empty' => true);
                return array(
                    [
                        $addons_module[0],
                        $addons_module[1],
                        $moduleAtts
                    ],
                    [
                        $addontabs_module[0],
                        $addontabs_module[1],
                        $moduleAtts
                    ],
                );
        }

        return null;
    }

    protected function getModuleClasses(array $componentVariation, array &$props)
    {
        $ret = parent::getModuleClasses($componentVariation, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        switch ($componentVariation[1]) {
            case self::MODULE_WINDOW_ADDONS:
                list($addons_submodule, $addontabs_submodule) = $this->getInnerSubmodules($componentVariation);
                $addonsSubmoduleOutputName = \PoP\ComponentModel\Facades\Modules\ModuleHelpersFacade::getInstance()->getModuleOutputName($addons_submodule);
                $addontabsSubmoduleOutputName = \PoP\ComponentModel\Facades\Modules\ModuleHelpersFacade::getInstance()->getModuleOutputName($addontabs_submodule);
                $ret[$addonsSubmoduleOutputName] = 'container-fluid offcanvas pop-waypoints-context scrollable addons perfect-scrollbar vertical';
                $ret[$addontabsSubmoduleOutputName] = 'offcanvas pop-waypoints-context scrollable addontabs perfect-scrollbar horizontal navbar navbar-main navbar-addons';
                break;
        }

        return $ret;
    }

    protected function getModuleParams(array $componentVariation, array &$props)
    {
        $ret = parent::getModuleParams($componentVariation, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        switch ($componentVariation[1]) {
            case self::MODULE_WINDOW_ADDONS:
                list($addons_submodule, $addontabs_submodule) = $this->getInnerSubmodules($componentVariation);
                $addonsSubmoduleOutputName = \PoP\ComponentModel\Facades\Modules\ModuleHelpersFacade::getInstance()->getModuleOutputName($addons_submodule);
                $addontabsSubmoduleOutputName = \PoP\ComponentModel\Facades\Modules\ModuleHelpersFacade::getInstance()->getModuleOutputName($addontabs_submodule);
                $ret[$addonsSubmoduleOutputName] = array(
                    'data-frametarget' => POP_TARGET_ADDONS,
                    'data-clickframetarget' => \PoP\ConfigurationComponentModel\Constants\Targets::MAIN,
                    'data-offcanvas' => 'addons',
                );
                $ret[$addontabsSubmoduleOutputName] = array(
                    'data-frametarget' => POP_TARGET_ADDONS,
                    'data-offcanvas' => 'addontabs',
                );
                break;
        }

        return $ret;
    }
}


