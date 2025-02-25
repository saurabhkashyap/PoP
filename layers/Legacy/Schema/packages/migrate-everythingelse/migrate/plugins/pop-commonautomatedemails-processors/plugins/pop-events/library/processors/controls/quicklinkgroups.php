<?php

class PoPTheme_Wassup_EM_AE_Module_Processor_QuicklinkGroups extends PoP_Module_Processor_ControlGroupsBase
{
    public final const COMPONENT_QUICKLINKGROUP_EVENTBOTTOM = 'quicklinkgroup-automatedemails-eventbottom';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_QUICKLINKGROUP_EVENTBOTTOM,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_QUICKLINKGROUP_EVENTBOTTOM:
                $ret[] = [PoP_Module_Processor_QuicklinkButtonGroups::class, PoP_Module_Processor_QuicklinkButtonGroups::COMPONENT_QUICKLINKBUTTONGROUP_COMMENTS_LABEL];
                $ret[] = [GD_EM_Module_Processor_QuicklinkButtonGroups::class, GD_EM_Module_Processor_QuicklinkButtonGroups::COMPONENT_EM_QUICKLINKBUTTONGROUP_DOWNLOADLINKS];
                break;
        }

        return $ret;
    }
}


