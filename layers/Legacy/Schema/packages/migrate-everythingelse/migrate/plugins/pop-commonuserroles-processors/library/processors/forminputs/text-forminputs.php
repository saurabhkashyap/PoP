<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_URE_Module_Processor_TextFormInputs extends PoP_Module_Processor_TextFormInputsBase
{
    public final const COMPONENT_URE_FORMINPUT_CUP_CONTACTPERSON = 'forminput-ure-cup-contactperson';
    public final const COMPONENT_URE_FORMINPUT_CUP_CONTACTNUMBER = 'forminput-ure-cup-contactnumber';
    public final const COMPONENT_URE_FORMINPUT_CUP_LASTNAME = 'forminput-ure-cup-lastName';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_URE_FORMINPUT_CUP_LASTNAME,
            self::COMPONENT_URE_FORMINPUT_CUP_CONTACTPERSON,
            self::COMPONENT_URE_FORMINPUT_CUP_CONTACTNUMBER,
        );
    }

    public function getLabelText(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_URE_FORMINPUT_CUP_LASTNAME:
                return TranslationAPIFacade::getInstance()->__('Last name', 'ure-popprocessors');

            case self::COMPONENT_URE_FORMINPUT_CUP_CONTACTPERSON:
                return TranslationAPIFacade::getInstance()->__('Contact person', 'ure-popprocessors');

            case self::COMPONENT_URE_FORMINPUT_CUP_CONTACTNUMBER:
                return TranslationAPIFacade::getInstance()->__('Telephone / Fax', 'ure-popprocessors');
        }
        
        return parent::getLabelText($component, $props);
    }

    public function getLabel(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getLabel($component, $props);

        switch ($component->name) {
            case self::COMPONENT_URE_FORMINPUT_CUP_CONTACTPERSON:
                return '<i class="fa fa-fw fa-user"></i>'.$ret;

            case self::COMPONENT_URE_FORMINPUT_CUP_CONTACTNUMBER:
                return '<i class="fa fa-fw fa-phone"></i>'.$ret;
        }
        
        return $ret;
    }

    public function getDbobjectField(\PoP\ComponentModel\Component\Component $component): ?string
    {
        switch ($component->name) {
            case self::COMPONENT_URE_FORMINPUT_CUP_LASTNAME:
                return 'lastName';

            case self::COMPONENT_URE_FORMINPUT_CUP_CONTACTPERSON:
                return 'contactPerson';

            case self::COMPONENT_URE_FORMINPUT_CUP_CONTACTNUMBER:
                return 'contactNumber';
        }
        
        return parent::getDbobjectField($component);
    }
}



