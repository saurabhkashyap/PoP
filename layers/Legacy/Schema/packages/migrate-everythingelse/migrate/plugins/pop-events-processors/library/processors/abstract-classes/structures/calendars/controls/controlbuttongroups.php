<?php

class PoP_Module_Processor_CalendarControlButtonGroups extends PoP_Module_Processor_ControlButtonGroupsBase
{
    public final const MODULE_CALENDARCONTROLBUTTONGROUP_CALENDAR = 'calendarcontrolbuttongroup-calendar';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CALENDARCONTROLBUTTONGROUP_CALENDAR],
        );
    }

    public function getSubComponentVariations(array $module): array
    {
        $ret = parent::getSubComponentVariations($module);
    
        switch ($module[1]) {
            case self::MODULE_CALENDARCONTROLBUTTONGROUP_CALENDAR:
                $ret[] = [PoP_Module_Processor_CalendarButtonControls::class, PoP_Module_Processor_CalendarButtonControls::MODULE_CALENDARBUTTONCONTROL_CALENDARPREV];
                $ret[] = [PoP_Module_Processor_CalendarButtonControls::class, PoP_Module_Processor_CalendarButtonControls::MODULE_CALENDARBUTTONCONTROL_CALENDARNEXT];
                break;
        }
        
        return $ret;
    }
}


