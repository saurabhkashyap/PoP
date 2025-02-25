<?php

class PoP_Module_Processor_UserHiddenInputAlertFormComponents extends PoP_Module_Processor_UserHiddenInputAlertFormComponentsBase
{
    public final const COMPONENT_FORMCOMPONENT_HIDDENINPUTALERT_LAYOUTUSER = 'formcomponent-hiddeninputalert-layoutuser';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FORMCOMPONENT_HIDDENINPUTALERT_LAYOUTUSER,
        );
    }
    
    public function getHiddenInputComponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FORMCOMPONENT_HIDDENINPUTALERT_LAYOUTUSER:
                return [PoP_Module_Processor_HiddenInputFormInputs::class, PoP_Module_Processor_HiddenInputFormInputs::COMPONENT_FORMINPUT_HIDDENINPUT_LAYOUTUSER];
        }

        return parent::getHiddenInputComponent($component);
    }
}



