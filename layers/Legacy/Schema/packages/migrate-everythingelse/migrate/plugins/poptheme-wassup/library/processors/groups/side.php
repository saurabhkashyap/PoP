<?php

class PoP_Module_Processor_SideGroups extends PoP_Module_Processor_MultiplesBase
{
    public final const MODULE_GROUP_SIDE = 'group-side';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_GROUP_SIDE],
        );
    }

    public function getSubComponentVariations(array $componentVariation): array
    {
        $ret = parent::getSubComponentVariations($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_GROUP_SIDE:
                // Allow GetPoP to only keep the Sections menu
                if ($componentVariations = \PoP\Root\App::applyFilters(
                    'PoP_Module_Processor_SideGroups:modules',
                    array(
                        [PoP_Module_Processor_CustomMenuMultiples::class, PoP_Module_Processor_CustomMenuMultiples::MODULE_MULTIPLE_MENU_SIDE_ADDNEW],
                        [PoP_Module_Processor_CustomMenuMultiples::class, PoP_Module_Processor_CustomMenuMultiples::MODULE_MULTIPLE_MENU_SIDE_SECTIONS_MULTITARGET],
                        [PoP_Module_Processor_CustomMenuMultiples::class, PoP_Module_Processor_CustomMenuMultiples::MODULE_MULTIPLE_MENU_SIDE_MYSECTIONS],
                    ),
                    $componentVariation
                )
                ) {
                    $ret = array_merge(
                        $ret,
                        $componentVariations
                    );
                }
                break;
        }

        return $ret;
    }
}


