<?php

use PoP\ComponentModel\State\ApplicationState;
use PoPCMSSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPCMSSchema\CustomPosts\Types\Status;

class PoP_AddHighlights_Module_Processor_SingleSectionTabPanelBlocks extends PoP_Module_Processor_SingleTabPanelSectionBlocksBase
{
    public final const MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT = 'block-tabpanel-singlerelatedhighlightcontent';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT],
        );
    }

    protected function getInnerSubmodules(array $componentVariation): array
    {
        $ret = parent::getInnerSubmodules($componentVariation);

        $inners = array(
            self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT => [PoP_AddHighlights_Module_Processor_SingleSectionTabPanelComponents::class, PoP_AddHighlights_Module_Processor_SingleSectionTabPanelComponents::MODULE_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT],
        );
        if ($inner = $inners[$componentVariation[1]] ?? null) {
            $ret[] = $inner;
        }

        return $ret;
    }

    protected function getControlgroupBottomSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_SUBMENUPOSTLIST];
        }

        return parent::getControlgroupBottomSubmodule($componentVariation);
    }

    public function initRequestProps(array $componentVariation, array &$props): void
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT:
                $post_id = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                if ($customPostTypeAPI->getStatus($post_id) !== Status::PUBLISHED) {
                    $this->setProp($componentVariation, $props, 'show-controls-bottom', false);
                }
                break;
        }

        parent::initRequestProps($componentVariation, $props);
    }

    public function getDelegatorfilterSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::MODULE_FILTER_HIGHLIGHTS];
        }

        return parent::getDelegatorfilterSubmodule($componentVariation);
    }
}


