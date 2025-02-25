<?php

class PoP_UserCommunities_ComponentProcessor_SectionBlocks extends PoP_Module_Processor_TabPanelSectionBlocksBase
{
    public final const COMPONENT_BLOCK_TABPANEL_COMMUNITIES = 'block-communities-tabpanel';
    public final const COMPONENT_BLOCK_TABPANEL_MYMEMBERS = 'block-mymembers-tabpanel';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_BLOCK_TABPANEL_COMMUNITIES,
            self::COMPONENT_BLOCK_TABPANEL_MYMEMBERS,
        );
    }

    public function getInnerSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        $inners = array(
            self::COMPONENT_BLOCK_TABPANEL_COMMUNITIES => [PoP_UserCommunities_ComponentProcessor_SectionTabPanelComponents::class, PoP_UserCommunities_ComponentProcessor_SectionTabPanelComponents::COMPONENT_TABPANEL_COMMUNITIES],
            self::COMPONENT_BLOCK_TABPANEL_MYMEMBERS => [PoP_UserCommunities_ComponentProcessor_SectionTabPanelComponents::class, PoP_UserCommunities_ComponentProcessor_SectionTabPanelComponents::COMPONENT_TABPANEL_MYMEMBERS],
        );
        if ($inner = $inners[$component->name] ?? null) {
            $ret[] = $inner;
        }

        return $ret;
    }

    protected function getControlgroupTopSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_TABPANEL_COMMUNITIES:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::COMPONENT_CONTROLGROUP_USERLIST];

            case self::COMPONENT_BLOCK_TABPANEL_MYMEMBERS:
                return [GD_URE_Module_Processor_CustomControlGroups::class, GD_URE_Module_Processor_CustomControlGroups::COMPONENT_CONTROLGROUP_MYMEMBERS];
        }

        return parent::getControlgroupTopSubcomponent($component);
    }

    public function getDelegatorfilterSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_TABPANEL_COMMUNITIES:
                return [GD_URE_Module_Processor_CustomFilters::class, GD_URE_Module_Processor_CustomFilters::COMPONENT_FILTER_COMMUNITIES];

            case self::COMPONENT_BLOCK_TABPANEL_MYMEMBERS:
                return [GD_URE_Module_Processor_CustomFilters::class, GD_URE_Module_Processor_CustomFilters::COMPONENT_FILTER_MYMEMBERS];
        }

        return parent::getDelegatorfilterSubcomponent($component);
    }
}
