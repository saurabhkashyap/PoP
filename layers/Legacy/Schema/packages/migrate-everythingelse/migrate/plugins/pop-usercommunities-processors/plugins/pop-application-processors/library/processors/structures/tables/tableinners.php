<?php

class PoP_UserCommunities_Module_Processor_TableInners extends PoP_Module_Processor_TableInnersBase
{
    public final const COMPONENT_TABLEINNER_MYMEMBERS = 'tableinner-mymembers';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_TABLEINNER_MYMEMBERS,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getLayoutSubcomponents($component);

        // Main layout
        switch ($component->name) {
            case self::COMPONENT_TABLEINNER_MYMEMBERS:
                $ret[] = [PoP_UserCommunities_Module_Processor_PreviewUserLayouts::class, PoP_UserCommunities_Module_Processor_PreviewUserLayouts::COMPONENT_LAYOUT_PREVIEWUSER_EDITMEMBERS];
                $ret[] = [GD_URE_Module_Processor_MemberStatusLayouts::class, GD_URE_Module_Processor_MemberStatusLayouts::COMPONENT_URE_LAYOUTUSER_MEMBERSTATUS];
                $ret[] = [GD_URE_Module_Processor_MemberPrivilegesLayouts::class, GD_URE_Module_Processor_MemberPrivilegesLayouts::COMPONENT_URE_LAYOUTUSER_MEMBERPRIVILEGES];
                $ret[] = [GD_URE_Module_Processor_MemberTagsLayouts::class, GD_URE_Module_Processor_MemberTagsLayouts::COMPONENT_URE_LAYOUTUSER_MEMBERTAGS];
                break;
        }

        return $ret;
    }
}


