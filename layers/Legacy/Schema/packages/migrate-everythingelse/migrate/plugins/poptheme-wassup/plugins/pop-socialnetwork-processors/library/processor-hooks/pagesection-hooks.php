<?php

class PoPTheme_Wassup_SocialNetwork_PageSectionHooks
{
    public function __construct()
    {
        \PoP\Root\App::getHookManager()->addAction(
            'PoP_Module_Processor_CustomTabPanePageSections:get_props_block_initial:addons',
            array($this, 'initModelPropsAddons'),
            10,
            3
        );
    }

    public function initModelPropsAddons(array $module, $props_in_array, $processor)
    {
        $props = &$props_in_array[0];
        switch ($module[1]) {
            case PoP_Module_Processor_TabPanes::MODULE_PAGESECTION_ADDONS:
                $processor->setProp([PoP_SocialNetwork_Module_Processor_Blocks::class, PoP_SocialNetwork_Module_Processor_Blocks::MODULE_BLOCK_CONTACTUSER], $props, 'title', '');
                break;
        }
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_SocialNetwork_PageSectionHooks();
