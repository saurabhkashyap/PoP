<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

class PoP_LocationPostLinksCreation_Module_Processor_FormMultipleComponents extends PoP_Module_Processor_MultiplesBase
{
    public final const MODULE_MULTICOMPONENT_FORM_LOCATIONPOSTLINK_RIGHTSIDE = 'multicomponent-form-locationpostlink-rightside';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_MULTICOMPONENT_FORM_LOCATIONPOSTLINK_RIGHTSIDE],
        );
    }

    public function getSubComponentVariations(array $componentVariation): array
    {
        $ret = parent::getSubComponentVariations($componentVariation);

        $status = GD_CreateUpdate_Utils::moderate() ?
            [Wassup_Module_Processor_FormMultipleComponents::class, Wassup_Module_Processor_FormMultipleComponents::MODULE_MULTICOMPONENT_FORMINPUTS_MODERATEDPUBLISH] :
            [Wassup_Module_Processor_FormMultipleComponents::class, Wassup_Module_Processor_FormMultipleComponents::MODULE_MULTICOMPONENT_FORMINPUTS_UNMODERATEDPUBLISH];

        switch ($componentVariation[1]) {
            case self::MODULE_MULTICOMPONENT_FORM_LOCATIONPOSTLINK_RIGHTSIDE:
                $details = array(
                    self::MODULE_MULTICOMPONENT_FORM_LOCATIONPOSTLINK_RIGHTSIDE => [PoP_LocationPostLinks_Module_Processor_FormWidgets::class, PoP_LocationPostLinks_Module_Processor_FormWidgets::MODULE_WIDGET_FORM_LOCATIONPOSTLINKDETAILS],
                );
                $ret[] = $details[$componentVariation[1]];
                $ret[] = [Wassup_Module_Processor_FormWidgets::class, Wassup_Module_Processor_FormWidgets::MODULE_WIDGET_FORM_FEATUREDIMAGE];
                $ret[] = [Wassup_Module_Processor_FormWidgets::class, Wassup_Module_Processor_FormWidgets::MODULE_WIDGET_FORM_METAINFORMATION];
                $ret[] = $status;
                break;
        }

        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        switch ($componentVariation[1]) {
            case self::MODULE_MULTICOMPONENT_FORM_LOCATIONPOSTLINK_RIGHTSIDE:
                if (!($classs = $this->getProp($componentVariation, $props, 'forminput-publish-class')/*$this->get_general_prop($props, 'forminput-publish-class')*/)) {
                    $classs = 'alert alert-info';
                }
                $status = GD_CreateUpdate_Utils::moderate() ?
                    [Wassup_Module_Processor_FormMultipleComponents::class, Wassup_Module_Processor_FormMultipleComponents::MODULE_MULTICOMPONENT_FORMINPUTS_MODERATEDPUBLISH] :
                    [Wassup_Module_Processor_FormMultipleComponents::class, Wassup_Module_Processor_FormMultipleComponents::MODULE_MULTICOMPONENT_FORMINPUTS_UNMODERATEDPUBLISH];
                $this->appendProp($status, $props, 'class', $classs);
                break;
        }

        parent::initModelProps($componentVariation, $props);
    }
}



