<?php

class PoP_AddHighlights_Module_Processor_SectionTabPanelBlocks extends PoP_Module_Processor_TabPanelSectionBlocksBase
{
    public final const MODULE_BLOCK_TABPANEL_HIGHLIGHTS = 'block-tabpanel-highlights';
    public final const MODULE_BLOCK_TABPANEL_MYHIGHLIGHTS = 'block-tabpanel-myhighlights';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BLOCK_TABPANEL_HIGHLIGHTS],
            [self::class, self::MODULE_BLOCK_TABPANEL_MYHIGHLIGHTS],
        );
    }

    protected function getInnerSubmodules(array $componentVariation): array
    {
        $ret = parent::getInnerSubmodules($componentVariation);

        $inners = array(
            self::MODULE_BLOCK_TABPANEL_HIGHLIGHTS => [PoP_AddHighlights_Module_Processor_SectionTabPanelComponents::class, PoP_AddHighlights_Module_Processor_SectionTabPanelComponents::MODULE_TABPANEL_HIGHLIGHTS],
            self::MODULE_BLOCK_TABPANEL_MYHIGHLIGHTS => [PoP_AddHighlights_Module_Processor_SectionTabPanelComponents::class, PoP_AddHighlights_Module_Processor_SectionTabPanelComponents::MODULE_TABPANEL_MYHIGHLIGHTS],
        );
        if ($inner = $inners[$componentVariation[1]] ?? null) {
            $ret[] = $inner;
        }

        return $ret;
    }

    protected function getControlgroupTopSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_TABPANEL_HIGHLIGHTS:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_POSTLIST];

            case self::MODULE_BLOCK_TABPANEL_MYHIGHLIGHTS:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_MYCUSTOMPOSTLIST];
        }

        return parent::getControlgroupTopSubmodule($componentVariation);
    }

    public function getDelegatorfilterSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_TABPANEL_HIGHLIGHTS:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::MODULE_FILTER_HIGHLIGHTS];

            case self::MODULE_BLOCK_TABPANEL_MYHIGHLIGHTS:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::MODULE_FILTER_MYHIGHLIGHTS];
        }

        return parent::getDelegatorfilterSubmodule($componentVariation);
    }
}


