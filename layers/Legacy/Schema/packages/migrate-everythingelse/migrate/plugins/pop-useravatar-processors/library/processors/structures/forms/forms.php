<?php

class PoP_UserAvatarProcessors_Module_Processor_UserForms extends PoP_Module_Processor_FormsBase
{
    public final const COMPONENT_FORM_USERAVATAR_UPDATE = 'form-useravatar-update';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FORM_USERAVATAR_UPDATE,
        );
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FORM_USERAVATAR_UPDATE:
                return [PoP_UserAvatarProcessors_Module_Processor_UserFormInners::class, PoP_UserAvatarProcessors_Module_Processor_UserFormInners::COMPONENT_FORMINNER_USERAVATAR_UPDATE];
        }

        return parent::getInnerSubcomponent($component);
    }
}



