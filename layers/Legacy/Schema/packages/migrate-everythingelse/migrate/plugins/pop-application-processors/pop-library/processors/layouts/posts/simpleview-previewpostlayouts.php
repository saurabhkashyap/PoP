<?php

class PoP_Module_Processor_CustomSimpleViewPreviewPostLayouts extends PoP_Module_Processor_CustomSimpleViewPreviewPostLayoutsBase
{
    public final const MODULE_LAYOUT_PREVIEWPOST_SIMPLEVIEW = 'layout-previewpost-simpleview';
    public final const MODULE_LAYOUT_PREVIEWPOST_MULTIPLESIMPLEVIEW = 'layout-previewpost-multiplesimpleview';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_PREVIEWPOST_SIMPLEVIEW],
            [self::class, self::MODULE_LAYOUT_PREVIEWPOST_MULTIPLESIMPLEVIEW],
        );
    }

    public function getQuicklinkgroupTopSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_LAYOUT_PREVIEWPOST_SIMPLEVIEW:
            case self::MODULE_LAYOUT_PREVIEWPOST_MULTIPLESIMPLEVIEW:
                return [PoP_Module_Processor_CustomQuicklinkGroups::class, PoP_Module_Processor_CustomQuicklinkGroups::MODULE_QUICKLINKGROUP_POST];
        }

        return parent::getQuicklinkgroupTopSubmodule($componentVariation);
    }

    public function getAbovecontentSubmodules(array $componentVariation)
    {
        $ret = parent::getAbovecontentSubmodules($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_LAYOUT_PREVIEWPOST_MULTIPLESIMPLEVIEW:
                $ret[] = [PoP_Module_Processor_MultiplePostLayouts::class, PoP_Module_Processor_MultiplePostLayouts::MODULE_LAYOUT_MULTIPLECONTENT_SIMPLEVIEW_ABOVECONTENT];
                break;
        }

        return $ret;
    }
}


