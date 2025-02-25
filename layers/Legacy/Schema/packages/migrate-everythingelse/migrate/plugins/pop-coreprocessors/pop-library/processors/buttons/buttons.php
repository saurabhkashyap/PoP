<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_Module_Processor_Buttons extends PoP_Module_Processor_ButtonsBase
{
    public final const COMPONENT_BUTTON_PRINT_PREVIEWDROPDOWN = 'button-print-previewdropdown';
    public final const COMPONENT_BUTTON_PRINT_SOCIALMEDIA = 'button-print-socialmedia';
    public final const COMPONENT_BUTTON_POSTPERMALINK = 'button-postpermalink';
    public final const COMPONENT_BUTTON_POSTCOMMENTS = 'postbutton-comments';
    public final const COMPONENT_BUTTON_POSTCOMMENTS_LABEL = 'postbutton-comments-label';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_BUTTON_PRINT_PREVIEWDROPDOWN,
            self::COMPONENT_BUTTON_PRINT_SOCIALMEDIA,
            self::COMPONENT_BUTTON_POSTPERMALINK,
            self::COMPONENT_BUTTON_POSTCOMMENTS,
            self::COMPONENT_BUTTON_POSTCOMMENTS_LABEL,
        );
    }

    public function getButtoninnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BUTTON_PRINT_PREVIEWDROPDOWN:
                return [PoP_Module_Processor_ButtonInners::class, PoP_Module_Processor_ButtonInners::COMPONENT_BUTTONINNER_PRINT_PREVIEWDROPDOWN];

            case self::COMPONENT_BUTTON_PRINT_SOCIALMEDIA:
                return [PoP_Module_Processor_ButtonInners::class, PoP_Module_Processor_ButtonInners::COMPONENT_BUTTONINNER_PRINT_SOCIALMEDIA];

            case self::COMPONENT_BUTTON_POSTPERMALINK:
                return [PoP_Module_Processor_ButtonInners::class, PoP_Module_Processor_ButtonInners::COMPONENT_BUTTONINNER_POSTPERMALINK];

            case self::COMPONENT_BUTTON_POSTCOMMENTS:
                return [PoP_Module_Processor_ButtonInners::class, PoP_Module_Processor_ButtonInners::COMPONENT_BUTTONINNER_POSTCOMMENTS];

            case self::COMPONENT_BUTTON_POSTCOMMENTS_LABEL:
                return [PoP_Module_Processor_ButtonInners::class, PoP_Module_Processor_ButtonInners::COMPONENT_BUTTONINNER_POSTCOMMENTS_LABEL];
        }

        return parent::getButtoninnerSubcomponent($component);
    }

    public function getUrlField(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BUTTON_PRINT_PREVIEWDROPDOWN:
            case self::COMPONENT_BUTTON_PRINT_SOCIALMEDIA:
                return 'printURL';

            case self::COMPONENT_BUTTON_POSTCOMMENTS:
            case self::COMPONENT_BUTTON_POSTCOMMENTS_LABEL:
                return 'commentsURL';
        }

        return parent::getUrlField($component);
    }

    public function getTitle(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_BUTTON_PRINT_PREVIEWDROPDOWN:
            case self::COMPONENT_BUTTON_PRINT_SOCIALMEDIA:
                return TranslationAPIFacade::getInstance()->__('Print', 'pop-coreprocessors');

            case self::COMPONENT_BUTTON_POSTEDIT:
                return TranslationAPIFacade::getInstance()->__('Edit', 'pop-coreprocessors');

            case self::COMPONENT_BUTTON_POSTVIEW:
                return TranslationAPIFacade::getInstance()->__('View', 'pop-coreprocessors');

            case self::COMPONENT_BUTTON_POSTPERMALINK:
                return TranslationAPIFacade::getInstance()->__('Permalink', 'pop-coreprocessors');

            case self::COMPONENT_BUTTON_POSTCOMMENTS:
            case self::COMPONENT_BUTTON_POSTCOMMENTS_LABEL:
                return TranslationAPIFacade::getInstance()->__('Comments', 'pop-coreprocessors');
        }

        return parent::getTitle($component, $props);
    }

    public function getLinktarget(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_BUTTON_PRINT_PREVIEWDROPDOWN:
            case self::COMPONENT_BUTTON_PRINT_SOCIALMEDIA:
                return GD_URLPARAM_TARGET_PRINT;
        }

        return parent::getLinktarget($component, $props);
    }

    public function getBtnClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getBtnClass($component, $props);

        switch ($component->name) {
            case self::COMPONENT_BUTTON_PRINT_SOCIALMEDIA:
                $ret .= ' socialmedia-item socialmedia-print';
                break;

            case self::COMPONENT_BUTTON_POSTPERMALINK:
            case self::COMPONENT_BUTTON_POSTCOMMENTS:
            case self::COMPONENT_BUTTON_POSTCOMMENTS_LABEL:
                $ret .= ' btn btn-link';
                break;
        }

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_BUTTON_PRINT_SOCIALMEDIA:
                // Artificial property added to identify the template when adding component-resources
                $this->setProp($component, $props, 'resourceloader', 'socialmedia');
                break;
        }

        parent::initModelProps($component, $props);
    }
}


