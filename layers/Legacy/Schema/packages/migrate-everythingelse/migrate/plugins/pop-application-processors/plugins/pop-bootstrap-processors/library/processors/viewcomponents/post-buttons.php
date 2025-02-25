<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoPGenericForms_Bootstrap_Module_Processor_PostViewComponentButtons extends PoP_Module_Processor_PostHeaderViewComponentButtonsBase
{
    public final const COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA = 'viewcomponent-postbutton-sharebyemail-socialmedia';
    public final const COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_PREVIEWDROPDOWN = 'viewcomponent-postbutton-sharebyemail-previewdropdown';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA,
            self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_PREVIEWDROPDOWN,
        );
    }

    public function getButtoninnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $buttoninners = array(
            self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA => [PoP_GenericForms_Bootstrap_Module_Processor_ViewComponentButtonInners::class, PoP_GenericForms_Bootstrap_Module_Processor_ViewComponentButtonInners::COMPONENT_VIEWCOMPONENT_BUTTONINNER_SHAREBYEMAIL_SOCIALMEDIA],
            self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_PREVIEWDROPDOWN => [PoP_GenericForms_Bootstrap_Module_Processor_ViewComponentButtonInners::class, PoP_GenericForms_Bootstrap_Module_Processor_ViewComponentButtonInners::COMPONENT_VIEWCOMPONENT_BUTTONINNER_SHAREBYEMAIL_PREVIEWDROPDOWN],
        );
        if ($buttoninner = $buttoninners[$component->name] ?? null) {
            return $buttoninner;
        }

        return parent::getButtoninnerSubcomponent($component);
    }

    public function getBtnClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getBtnClass($component, $props);

        switch ($component->name) {
            case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA:
                $ret .= ' socialmedia-item socialmedia-email';
                break;
        }

        return $ret;
    }

    public function getTitle(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA:
            case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_PREVIEWDROPDOWN:
                return TranslationAPIFacade::getInstance()->__('Share by email', 'pop-coreprocessors');
        }

        return parent::getTitle($component, $props);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA:
            case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_PREVIEWDROPDOWN:
                $this->mergeProp(
                    $component,
                    $props,
                    'params',
                    array(
                        'data-toggle' => 'modal'
                    )
                );
                break;
        }

        switch ($component->name) {
            case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA:
                // Artificial property added to identify the template when adding component-resources
                $this->setProp($component, $props, 'resourceloader', 'socialmedia');
                break;
        }

        parent::initModelProps($component, $props);
    }

    public function getUrl(\PoP\ComponentModel\Component\Component $component, array &$props)
    {

        // If PoP Engine Web Platform is not defined, then there is no `getFrontendId`
        if (defined('POP_ENGINEWEBPLATFORM_INITIALIZED')) {
            $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
            switch ($component->name) {
                case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA:
                case self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_PREVIEWDROPDOWN:
                    $modals = array(
                        self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_SOCIALMEDIA => [PoP_Module_Processor_GFModalComponents::class, PoP_Module_Processor_GFModalComponents::COMPONENT_MODAL_SHAREBYEMAIL],
                        self::COMPONENT_VIEWCOMPONENT_BUTTON_POST_SHAREBYEMAIL_PREVIEWDROPDOWN => [PoP_Module_Processor_GFModalComponents::class, PoP_Module_Processor_GFModalComponents::COMPONENT_MODAL_SHAREBYEMAIL],
                    );

                    $modal = $modals[$component->name];
                    $modal_id = $componentprocessor_manager->getComponentProcessor($modal)->getFrontendId($modal, $props);
                    return '#'.PoP_Bootstrap_Utils::getFrontendId($modal_id, 'modal');
            }
        }

        return parent::getUrl($component, $props);
    }
}



