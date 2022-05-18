<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_ContentCreation_Module_Processor_ViewComponentButtonInners extends PoP_Module_Processor_ButtonInnersBase
{
    public final const MODULE_VIEWCOMPONENT_BUTTONINNER_FLAG_SOCIALMEDIA = 'viewcomponent-buttoninner-flag-socialmedia';
    public final const MODULE_VIEWCOMPONENT_BUTTONINNER_FLAG_PREVIEWDROPDOWN = 'viewcomponent-buttoninner-flag-previewdropdown';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_VIEWCOMPONENT_BUTTONINNER_FLAG_SOCIALMEDIA],
            [self::class, self::MODULE_VIEWCOMPONENT_BUTTONINNER_FLAG_PREVIEWDROPDOWN],
        );
    }
    
    public function getFontawesome(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_VIEWCOMPONENT_BUTTONINNER_FLAG_SOCIALMEDIA:
                return 'fa-fw fa-flag fa-lg';

            case self::MODULE_VIEWCOMPONENT_BUTTONINNER_FLAG_PREVIEWDROPDOWN:
                return 'fa-fw fa-flag';
        }
        
        return parent::getFontawesome($componentVariation, $props);
    }

    public function getBtnTitle(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_VIEWCOMPONENT_BUTTONINNER_FLAG_PREVIEWDROPDOWN:
                return TranslationAPIFacade::getInstance()->__('Flag as inappropriate', 'pop-coreprocessors');
        }
        
        return parent::getBtnTitle($componentVariation);
    }
}


