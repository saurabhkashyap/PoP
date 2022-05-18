<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_Custom_EM_Module_Processor_Buttons extends PoP_Module_Processor_PreloadTargetDataButtonsBase
{
    public final const MODULE_BUTTON_EVENT_CREATE = 'postbutton-event-create';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BUTTON_EVENT_CREATE],
        );
    }

    public function getButtoninnerSubmodule(array $componentVariation)
    {
        $buttoninners = array(
            self::MODULE_BUTTON_EVENT_CREATE => [GD_Custom_EM_Module_Processor_ButtonInners::class, GD_Custom_EM_Module_Processor_ButtonInners::MODULE_BUTTONINNER_EVENT_CREATE],
        );
        if ($buttoninner = $buttoninners[$componentVariation[1]] ?? null) {
            return $buttoninner;
        }

        return parent::getButtoninnerSubmodule($componentVariation);
    }

    public function getTargetDynamicallyRenderedSubmodules(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BUTTON_EVENT_CREATE:
                return array(
                    [PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_POST],
                );
        }

        return parent::getTargetDynamicallyRenderedSubmodules($componentVariation);
    }

    public function getLinktarget(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BUTTON_EVENT_CREATE:
                if (PoP_Application_Utils::getAddcontentTarget() == POP_TARGET_ADDONS) {
                    return POP_TARGET_ADDONS;
                }
                break;
        }

        return parent::getLinktarget($componentVariation, $props);
    }

    public function getTitle(array $componentVariation, array &$props)
    {
        $titles = array(
            self::MODULE_BUTTON_EVENT_CREATE => TranslationAPIFacade::getInstance()->__('Event', 'poptheme-wassup'),
        );
        if ($title = $titles[$componentVariation[1]] ?? null) {
            return $title;
        }

        return parent::getTitle($componentVariation, $props);
    }

    public function getUrlField(array $componentVariation)
    {
        $fields = array(
            self::MODULE_BUTTON_EVENT_CREATE => 'addEventURL',
        );
        if ($field = $fields[$componentVariation[1]] ?? null) {
            return $field;
        }

        return parent::getUrlField($componentVariation);
    }
}



