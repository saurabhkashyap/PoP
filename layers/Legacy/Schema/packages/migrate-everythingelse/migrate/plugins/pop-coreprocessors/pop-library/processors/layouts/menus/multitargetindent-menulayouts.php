<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_Module_Processor_MultiTargetIndentMenuLayouts extends PoP_Module_Processor_MultiTargetIndentMenuLayoutsBase
{
    public final const COMPONENT_LAYOUT_MENU_MULTITARGETINDENT = 'layout-menu-multitargetindent';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUT_MENU_MULTITARGETINDENT,
        );
    }

    public function getTargets(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getTargets($component, $props);

        switch ($component->name) {
            case self::COMPONENT_LAYOUT_MENU_MULTITARGETINDENT:
                $ret[POP_TARGET_NAVIGATOR] = '<i class="fa fa-fw fa-angle-right"></i>';
                
                // $icon = '<i class="fa fa-fw fa-angle-right"></i>';
                // $ret[\PoP\ConfigurationComponentModel\Constants\Targets::MAIN] = $icon.TranslationAPIFacade::getInstance()->__('Main', 'pop-coreprocessors');
                // $ret[POP_TARGET_NAVIGATOR] = $icon.TranslationAPIFacade::getInstance()->__('Navigator', 'pop-coreprocessors');
                // $ret[POP_TARGET_ADDONS] = $icon.TranslationAPIFacade::getInstance()->__('Floating', 'pop-coreprocessors');
                break;
        }
    
        return $ret;
    }

    public function getMultitargetClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_MENU_MULTITARGETINDENT:
                // Do not show for mobile phone
                return 'hidden-xs';
        }

        return parent::getMultitargetClass($component, $props);
    }

    public function getMultitargetTooltip(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_MENU_MULTITARGETINDENT:
                return TranslationAPIFacade::getInstance()->__('Navigate', 'pop-coreprocessors');
        }

        return parent::getMultitargetTooltip($component, $props);
    }

    // function getDropdownmenuClass(\PoP\ComponentModel\Component\Component $component, array &$props) {

    //     switch ($component->name) {

    //         case self::COMPONENT_LAYOUT_MENU_MULTITARGETINDENT:
                
    //             // Do not show for mobile phone
    //             return 'hidden-xs';
    //     }

    //     return parent::getDropdownmenuClass($component, $props);
    // }
}


