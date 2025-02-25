<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_CAP_Module_Processor_TypeaheadTextFormInputs extends PoP_Module_Processor_TextFormInputsBase
{
    public final const COMPONENT_FORMINPUT_TEXT_TYPEAHEADPOSTAUTHORS = 'forminput-text-typeaheadpostauthors';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FORMINPUT_TEXT_TYPEAHEADPOSTAUTHORS,
        );
    }

    public function getLabelText(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_FORMINPUT_TEXT_TYPEAHEADPOSTAUTHORS:
                return TranslationAPIFacade::getInstance()->__('Author(s)', 'pop-coreprocessors');
        }
        
        return parent::getLabelText($component, $props);
    }
}



