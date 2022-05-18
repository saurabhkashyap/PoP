<?php

class GD_Wassup_Module_Processor_DropdownButtonControls extends PoP_Module_Processor_DropdownButtonControlsBase
{
    public final const MODULE_DROPDOWNBUTTONCONTROL_CLOSETOGGLE = 'dropdownbuttoncontrol-closetoggle';
    public final const MODULE_DROPDOWNBUTTONCONTROL_QUICKVIEWCLOSETOGGLE = 'dropdownbuttoncontrol-quickviewclosetoggle';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DROPDOWNBUTTONCONTROL_CLOSETOGGLE],
            [self::class, self::MODULE_DROPDOWNBUTTONCONTROL_QUICKVIEWCLOSETOGGLE],
        );
    }

    public function getSubComponentVariations(array $componentVariation): array
    {
        $ret = parent::getSubComponentVariations($componentVariation);
    
        switch ($componentVariation[1]) {
            case self::MODULE_DROPDOWNBUTTONCONTROL_CLOSETOGGLE:
                $ret[] = [GD_Wassup_Module_Processor_AnchorControls::class, GD_Wassup_Module_Processor_AnchorControls::MODULE_ANCHORCONTROL_TOGGLESIDEINFO];
                $ret[] = [GD_Wassup_Module_Processor_AnchorControls::class, GD_Wassup_Module_Processor_AnchorControls::MODULE_ANCHORCONTROL_TOGGLESIDEINFOXS];
                $ret[] = [PoP_Module_Processor_AnchorControls::class, PoP_Module_Processor_AnchorControls::MODULE_ANCHORCONTROL_CLOSEPAGE];
                break;

            case self::MODULE_DROPDOWNBUTTONCONTROL_QUICKVIEWCLOSETOGGLE:
                $ret[] = [GD_Wassup_Module_Processor_AnchorControls::class, GD_Wassup_Module_Processor_AnchorControls::MODULE_ANCHORCONTROL_TOGGLEQUICKVIEWINFO];
                $ret[] = [PoP_Module_Processor_AnchorControls::class, PoP_Module_Processor_AnchorControls::MODULE_ANCHORCONTROL_CLOSEPAGE];
                break;
        }
        
        return $ret;
    }

    public function getBtnClass(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DROPDOWNBUTTONCONTROL_CLOSETOGGLE:
            case self::MODULE_DROPDOWNBUTTONCONTROL_QUICKVIEWCLOSETOGGLE:
                return 'btn btn-link';
        }
        
        return parent::getBtnClass($componentVariation);
    }

    public function getFontawesome(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DROPDOWNBUTTONCONTROL_CLOSETOGGLE:
            case self::MODULE_DROPDOWNBUTTONCONTROL_QUICKVIEWCLOSETOGGLE:
                return 'fa-ellipsis-v';
        }

        return parent::getFontawesome($componentVariation, $props);
    }
}


