<?php

class PoP_UserStance_Module_Processor_PostHiddenInputAlertFormComponents extends PoP_Module_Processor_PostHiddenInputAlertFormComponentsBase
{
    public final const COMPONENT_FORMCOMPONENT_HIDDENINPUTALERT_STANCETARGET = 'formcomponent-hiddeninputalert-stancetarget';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FORMCOMPONENT_HIDDENINPUTALERT_STANCETARGET,
        );
    }
    
    public function getHiddenInputComponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FORMCOMPONENT_HIDDENINPUTALERT_STANCETARGET:
                return [PoP_UserStance_Processor_HiddenInputFormInputs::class, PoP_UserStance_Processor_HiddenInputFormInputs::COMPONENT_FORMINPUT_HIDDENINPUT_STANCETARGET];
        }

        return parent::getHiddenInputComponent($component);
    }
}



