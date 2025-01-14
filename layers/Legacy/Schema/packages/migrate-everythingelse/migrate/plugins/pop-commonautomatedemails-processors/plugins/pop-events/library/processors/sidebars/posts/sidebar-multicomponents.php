<?php

class PoPTheme_Wassup_EM_AE_Module_Processor_PostMultipleSidebarComponents extends PoP_Module_Processor_MultiplesBase
{
    public final const COMPONENT_SIDEBARMULTICOMPONENT_AUTOMATEDEMAILS_EVENT = 'sidebarmulticomponent-automatedemails-event';
    
    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_SIDEBARMULTICOMPONENT_AUTOMATEDEMAILS_EVENT,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_SIDEBARMULTICOMPONENT_AUTOMATEDEMAILS_EVENT:
                $ret[] = [PoPTheme_Wassup_EM_AE_Module_Processor_Widgets::class, PoPTheme_Wassup_EM_AE_Module_Processor_Widgets::COMPONENT_EM_WIDGETCOMPACT_AUTOMATEDEMAILS_EVENTINFO];
                $ret[] = [PoP_Module_Processor_SidebarComponentWrappers::class, PoP_Module_Processor_SidebarComponentWrappers::COMPONENT_WIDGETWRAPPER_REFERENCES];
                $ret[] = [PoPTheme_Wassup_AE_Module_Processor_Widgets::class, PoPTheme_Wassup_AE_Module_Processor_Widgets::COMPONENT_WIDGETCOMPACT_AUTOMATEDEMAILS_POST_AUTHORS];
                break;
            break;
        }

        return $ret;
    }
}



