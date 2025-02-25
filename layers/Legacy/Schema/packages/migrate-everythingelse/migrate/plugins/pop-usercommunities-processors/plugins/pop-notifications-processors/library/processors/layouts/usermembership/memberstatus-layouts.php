<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class Wassup_URE_AAL_Module_Processor_MemberStatusLayouts extends GD_URE_Module_Processor_MemberStatusLayoutsBase
{
    public final const COMPONENT_UREAAL_LAYOUTUSER_MEMBERSTATUS = 'ure-aal-layoutuser-memberstatus-nodesc';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_UREAAL_LAYOUTUSER_MEMBERSTATUS,
        );
    }

    public function getDescription(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_UREAAL_LAYOUTUSER_MEMBERSTATUS:
                return sprintf(
                    '<em>%s</em>',
                    TranslationAPIFacade::getInstance()->__('Status:', 'poptheme-wassup')
                );
        }
    
        return parent::getDescription($component, $props);
    }
}


