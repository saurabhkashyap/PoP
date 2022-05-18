<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class Wassup_Module_Processor_Buttons extends PoP_Module_Processor_ButtonsBase
{
    public final const MODULE_BUTTON_ADDONSPOSTEDIT = 'button-addonspostedit';
    public final const MODULE_BUTTON_ADDONSORMAINPOSTEDIT = 'button-addonsormainpostedit';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BUTTON_ADDONSPOSTEDIT],
            [self::class, self::MODULE_BUTTON_ADDONSORMAINPOSTEDIT],
        );
    }

    public function getButtoninnerSubmodule(array $componentVariation)
    {
        $buttoninners = array(
            self::MODULE_BUTTON_ADDONSPOSTEDIT => [PoP_ContentCreation_Module_Processor_ButtonInners::class, PoP_ContentCreation_Module_Processor_ButtonInners::MODULE_BUTTONINNER_POSTEDIT],
            self::MODULE_BUTTON_ADDONSORMAINPOSTEDIT => [PoP_ContentCreation_Module_Processor_ButtonInners::class, PoP_ContentCreation_Module_Processor_ButtonInners::MODULE_BUTTONINNER_POSTEDIT],
        );
        if ($buttoninner = $buttoninners[$componentVariation[1]] ?? null) {
            return $buttoninner;
        }

        return parent::getButtoninnerSubmodule($componentVariation);
    }

    public function getUrlField(array $componentVariation)
    {
        $fields = array(
            self::MODULE_BUTTON_ADDONSPOSTEDIT => 'editURL',
            self::MODULE_BUTTON_ADDONSORMAINPOSTEDIT => 'editURL',
        );
        if ($field = $fields[$componentVariation[1]] ?? null) {
            return $field;
        }

        return parent::getUrlField($componentVariation);
    }

    public function getTitle(array $componentVariation, array &$props)
    {
        $titles = array(
            self::MODULE_BUTTON_ADDONSPOSTEDIT => TranslationAPIFacade::getInstance()->__('Edit', 'poptheme-wassup'),
            self::MODULE_BUTTON_ADDONSORMAINPOSTEDIT => TranslationAPIFacade::getInstance()->__('Edit', 'poptheme-wassup'),
        );
        if ($title = $titles[$componentVariation[1]] ?? null) {
            return $title;
        }

        return parent::getTitle($componentVariation, $props);
    }

    public function getLinktarget(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BUTTON_ADDONSPOSTEDIT:
                return POP_TARGET_ADDONS;

            case self::MODULE_BUTTON_ADDONSORMAINPOSTEDIT:
                if (PoP_Application_Utils::getAddcontentTarget() == POP_TARGET_ADDONS) {
                    return POP_TARGET_ADDONS;
                }
                break;
        }

        return parent::getLinktarget($componentVariation, $props);
    }

    public function getBtnClass(array $componentVariation, array &$props)
    {
        $ret = parent::getBtnClass($componentVariation, $props);

        switch ($componentVariation[1]) {
            case self::MODULE_BUTTON_ADDONSPOSTEDIT:
            case self::MODULE_BUTTON_ADDONSORMAINPOSTEDIT:
                $ret .= ' btn btn-xs btn-default';
                break;
        }

        return $ret;
    }
}


