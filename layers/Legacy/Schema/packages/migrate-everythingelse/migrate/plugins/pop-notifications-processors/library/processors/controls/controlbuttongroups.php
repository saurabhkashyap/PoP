<?php

class AAL_PoPProcessors_Module_Processor_ControlButtonGroups extends PoP_Module_Processor_ControlButtonGroupsBase
{
    public final const COMPONENT_AAL_CONTROLBUTTONGROUP_NOTIFICATIONLIST = 'controlbuttongroup-notificationlist';
    public final const COMPONENT_AAL_CONTROLBUTTONGROUP_NOTIFICATIONS_MARKALLASREAD = 'controlbuttongroup-notifications-markallasread';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_AAL_CONTROLBUTTONGROUP_NOTIFICATIONLIST,
            self::COMPONENT_AAL_CONTROLBUTTONGROUP_NOTIFICATIONS_MARKALLASREAD,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);
    
        switch ($component->name) {
            case self::COMPONENT_AAL_CONTROLBUTTONGROUP_NOTIFICATIONLIST:
                $ret[] = [AAL_PoPProcessors_Module_Processor_AnchorControls::class, AAL_PoPProcessors_Module_Processor_AnchorControls::COMPONENT_AAL_ANCHORCONTROL_NOTIFICATIONS];
                break;
        
            case self::COMPONENT_AAL_CONTROLBUTTONGROUP_NOTIFICATIONS_MARKALLASREAD:
                $ret[] = [AAL_PoPProcessors_Module_Processor_AnchorControls::class, AAL_PoPProcessors_Module_Processor_AnchorControls::COMPONENT_AAL_ANCHORCONTROL_NOTIFICATIONS_MARKALLASREAD];
                break;
        }
        
        return $ret;
    }
}


