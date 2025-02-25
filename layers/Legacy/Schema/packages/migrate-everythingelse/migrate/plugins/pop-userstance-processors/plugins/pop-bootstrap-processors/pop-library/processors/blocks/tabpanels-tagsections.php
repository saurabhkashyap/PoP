<?php

class UserStance_Module_Processor_TagSectionTabPanelBlocks extends PoP_Module_Processor_TagTabPanelSectionBlocksBase
{
    public final const COMPONENT_BLOCK_TABPANEL_TAGSTANCES = 'block-tabpanel-tagstances';
    public final const COMPONENT_BLOCK_TABPANEL_TAGSTANCES_PRO = 'block-tabpanel-tagstances-pro';
    public final const COMPONENT_BLOCK_TABPANEL_TAGSTANCES_NEUTRAL = 'block-tabpanel-tagstances-neutral';
    public final const COMPONENT_BLOCK_TABPANEL_TAGSTANCES_AGAINST = 'block-tabpanel-tagstances-against';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES,
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_PRO,
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_NEUTRAL,
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_AGAINST,
        );
    }

    protected function getInnerSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        $inners = array(
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES => [UserStance_Module_Processor_TagSectionTabPanelComponents::class, UserStance_Module_Processor_TagSectionTabPanelComponents::COMPONENT_TABPANEL_TAGSTANCES],
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_PRO => [UserStance_Module_Processor_TagSectionTabPanelComponents::class, UserStance_Module_Processor_TagSectionTabPanelComponents::COMPONENT_TABPANEL_TAGSTANCES_PRO],
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_NEUTRAL => [UserStance_Module_Processor_TagSectionTabPanelComponents::class, UserStance_Module_Processor_TagSectionTabPanelComponents::COMPONENT_TABPANEL_TAGSTANCES_NEUTRAL],
            self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_AGAINST => [UserStance_Module_Processor_TagSectionTabPanelComponents::class, UserStance_Module_Processor_TagSectionTabPanelComponents::COMPONENT_TABPANEL_TAGSTANCES_AGAINST],
        );
        if ($inner = $inners[$component->name] ?? null) {
            $ret[] = $inner;
        }

        return $ret;
    }

    public function getDelegatorfilterSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES:
                return [UserStance_Module_Processor_CustomFilters::class, UserStance_Module_Processor_CustomFilters::COMPONENT_FILTER_TAGSTANCES];

            case self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_PRO:
            case self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_NEUTRAL:
            case self::COMPONENT_BLOCK_TABPANEL_TAGSTANCES_AGAINST:
                return [UserStance_Module_Processor_CustomFilters::class, UserStance_Module_Processor_CustomFilters::COMPONENT_FILTER_TAGSTANCES_STANCE];
        }

        return parent::getDelegatorfilterSubcomponent($component);
    }
}


