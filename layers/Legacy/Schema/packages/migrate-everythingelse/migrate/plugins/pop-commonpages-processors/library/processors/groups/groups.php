<?php

class GD_CommonPages_Module_Processor_CustomGroups extends PoP_Module_Processor_MultiplesBase
{
    public final const MODULE_GROUP_WHOWEARE = 'group-whoweare';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_GROUP_WHOWEARE],
        );
    }

    public function getSubComponentVariations(array $module): array
    {
        $ret = parent::getSubComponentVariations($module);

        switch ($module[1]) {
            case self::MODULE_GROUP_WHOWEARE:
                // Allow to override with custom blocks
                $ret = array_merge(
                    $ret,
                    \PoP\Root\App::applyFilters(
                        'PoP_Module_Processor_CustomGroups:modules:whoweare',
                        array(
                            [GD_Custom_Module_Processor_CustomSectionBlocks::class, GD_Custom_Module_Processor_CustomSectionBlocks::MODULE_BLOCK_WHOWEARE_SCROLL_DETAILS]
                        )
                    )
                );
                break;
        }

        return $ret;
    }
}


