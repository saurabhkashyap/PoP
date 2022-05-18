<?php

class GD_AAL_Module_Processor_QuicklinkGroups extends PoP_Module_Processor_ControlGroupsBase
{
    public final const MODULE_AAL_QUICKLINKGROUP_NOTIFICATION = 'notifications-quicklinkgroup-notification';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_AAL_QUICKLINKGROUP_NOTIFICATION],
        );
    }

    public function getSubComponentVariations(array $module): array
    {
        $ret = parent::getSubComponentVariations($module);

        switch ($module[1]) {
            case self::MODULE_AAL_QUICKLINKGROUP_NOTIFICATION:
                $ret[] = [GD_AAL_Module_Processor_QuicklinkButtonGroups::class, GD_AAL_Module_Processor_QuicklinkButtonGroups::MODULE_AAL_QUICKLINKBUTTONGROUP_NOTIFICATION_MARKASREADUNREAD];
                break;
        }

        return $ret;
    }
}


