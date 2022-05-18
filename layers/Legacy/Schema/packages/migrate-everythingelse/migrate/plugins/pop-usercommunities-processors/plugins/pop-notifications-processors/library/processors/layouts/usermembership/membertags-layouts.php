<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class Wassup_URE_AAL_Module_Processor_MemberTagsLayouts extends GD_URE_Module_Processor_MemberTagsLayoutsBase
{
    public final const MODULE_UREAAL_LAYOUTUSER_MEMBERTAGS = 'ure-aal-layoutuser-membertags-desc';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_UREAAL_LAYOUTUSER_MEMBERTAGS],
        );
    }

    public function getDescription(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_UREAAL_LAYOUTUSER_MEMBERTAGS:
                return sprintf(
                    '<em>%s</em>',
                    TranslationAPIFacade::getInstance()->__('Tags:', 'poptheme-wassup')
                );
        }
    
        return parent::getDescription($componentVariation, $props);
    }
}


