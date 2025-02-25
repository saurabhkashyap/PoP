<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

class PoP_Volunteering_GFHelpers
{
    public static function getVolunteerFormFieldNames()
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        $gfinputname_components = array(
            POP_GENERICFORMS_GF_FORM_VOLUNTEER_FIELDNAME_NAME_ID => [PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_NAME],
            POP_GENERICFORMS_GF_FORM_VOLUNTEER_FIELDNAME_EMAIL_ID => [PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_EMAIL],
            POP_GENERICFORMS_GF_FORM_VOLUNTEER_FIELDNAME_PHONE_ID => [PoP_Volunteering_Module_Processor_TextFormInputs::class, PoP_Volunteering_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_PHONE],
            POP_GENERICFORMS_GF_FORM_VOLUNTEER_FIELDNAME_WHYVOLUNTEER_ID => [PoP_Volunteering_Module_Processor_TextareaFormInputs::class, PoP_Volunteering_Module_Processor_TextareaFormInputs::COMPONENT_FORMINPUT_WHYVOLUNTEER],
            POP_GENERICFORMS_GF_FORM_VOLUNTEER_FIELDNAME_PAGEURL_ID => [PoP_Module_Processor_TextFormInputs::class, PoP_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_TARGETURL],
            POP_GENERICFORMS_GF_FORM_VOLUNTEER_FIELDNAME_PAGETITLE_ID => [PoP_Module_Processor_TextFormInputs::class, PoP_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_POSTTITLE],
        );
        $fieldnames = array();
        foreach ($gfinputname_components as $gf_field_name => $component) {
            $fieldnames[$componentprocessor_manager->getComponentProcessor($component)->getName($component)] = $gf_field_name;
        }
        
        return $fieldnames;
    }

    public static function getVolunteerFormId()
    {
        return POP_GENERICFORMS_GF_FORM_VOLUNTEER_FORM_ID;
    }
}
