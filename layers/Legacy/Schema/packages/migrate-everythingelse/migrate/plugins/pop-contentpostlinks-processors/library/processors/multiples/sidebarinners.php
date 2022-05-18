<?php

class PoP_ContentPostLinks_Module_Processor_SidebarInners extends PoP_Module_Processor_MultiplesBase
{
    public final const MODULE_MULTIPLE_SECTIONINNER_POSTLINKS_SIDEBAR = 'multiple-sectioninner-contentpostlinks-sidebar';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_MULTIPLE_SECTIONINNER_POSTLINKS_SIDEBAR],
        );
    }

    public function getSubComponentVariations(array $module): array
    {
        $ret = parent::getSubComponentVariations($module);

        switch ($module[1]) {
            case self::MODULE_MULTIPLE_SECTIONINNER_POSTLINKS_SIDEBAR:
                $ret[] = [GD_Custom_Module_Processor_ButtonGroups::class, GD_Custom_Module_Processor_ButtonGroups::MODULE_BUTTONGROUP_SECTION];
                $ret[] = [PoP_ContentPostLinks_Module_Processor_CustomDelegatorFilters::class, PoP_ContentPostLinks_Module_Processor_CustomDelegatorFilters::MODULE_DELEGATORFILTER_CONTENTPOSTLINKS];
                break;
        }
        
        return $ret;
    }
}


