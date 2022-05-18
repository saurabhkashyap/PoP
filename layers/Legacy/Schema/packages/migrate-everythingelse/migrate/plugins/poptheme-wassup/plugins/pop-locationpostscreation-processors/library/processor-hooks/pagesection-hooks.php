<?php

class PoP_LocationPostsCreation_PageSectionHooks
{
    public function __construct()
    {
        \PoP\Root\App::addAction(
            'PoP_Module_Processor_CustomTabPanePageSections:get_props_block_initial:addons',
            $this->initModelPropsAddons(...),
            10,
            3
        );
    }

    public function initModelPropsAddons(array $componentVariation, $props_in_array, $processor)
    {
        $props = &$props_in_array[0];
        switch ($componentVariation[1]) {
            case PoP_Module_Processor_TabPanes::MODULE_PAGESECTION_ADDONS:
                if (PoP_Application_Utils::getAddcontentTarget() == POP_TARGET_ADDONS) {
                    $subComponentVariations = array(
                        [GD_Custom_EM_Module_Processor_CreateUpdatePostBlocks::class, GD_Custom_EM_Module_Processor_CreateUpdatePostBlocks::MODULE_BLOCK_LOCATIONPOST_CREATE],
                        [GD_Custom_EM_Module_Processor_CreateUpdatePostBlocks::class, GD_Custom_EM_Module_Processor_CreateUpdatePostBlocks::MODULE_BLOCK_LOCATIONPOST_UPDATE],
                    );
                    foreach ($subComponentVariations as $subComponentVariation) {
                        $processor->setProp($subComponentVariation, $props, 'title', '');
                    }
                }
                break;
        }
    }
}

/**
 * Initialization
 */
new PoP_LocationPostsCreation_PageSectionHooks();
