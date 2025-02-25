<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_Core_Bootstrap_Module_Processor_AnchorControls extends PoP_Module_Processor_AnchorControlsBase
{
    public final const COMPONENT_ANCHORCONTROL_EMBED = 'anchorcontrol-embed';
    public final const COMPONENT_ANCHORCONTROL_API = 'anchorcontrol-api';
    public final const COMPONENT_ANCHORCONTROL_COPYSEARCHURL = 'anchorcontrol-copysearchurl';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_ANCHORCONTROL_EMBED,
            self::COMPONENT_ANCHORCONTROL_API,
            self::COMPONENT_ANCHORCONTROL_COPYSEARCHURL,
        );
    }

    public function getLabel(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_EMBED:
                return TranslationAPIFacade::getInstance()->__('Embed', 'pop-coreprocessors');

            case self::COMPONENT_ANCHORCONTROL_API:
                return TranslationAPIFacade::getInstance()->__('API Data', 'pop-coreprocessors');

            case self::COMPONENT_ANCHORCONTROL_COPYSEARCHURL:
                return TranslationAPIFacade::getInstance()->__('Copy Search URL', 'pop-coreprocessors');
        }

        return parent::getLabel($component, $props);
    }
    public function getFontawesome(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_EMBED:
                return 'fa-code';

            case self::COMPONENT_ANCHORCONTROL_API:
                return 'fa-cog';

            case self::COMPONENT_ANCHORCONTROL_COPYSEARCHURL:
                return 'fa-link';
        }

        return parent::getFontawesome($component, $props);
    }
    public function getHref(\PoP\ComponentModel\Component\Component $component, array &$props)
    {

        // If PoP Engine Web Platform is not defined, then there is no `getFrontendId`
        if (defined('POP_ENGINEWEBPLATFORM_INITIALIZED')) {
            $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
            switch ($component->name) {
                case self::COMPONENT_ANCHORCONTROL_EMBED:
                case self::COMPONENT_ANCHORCONTROL_API:
                case self::COMPONENT_ANCHORCONTROL_COPYSEARCHURL:
                    $modals = array(
                        self::COMPONENT_ANCHORCONTROL_EMBED => [PoP_Module_Processor_ShareModalComponents::class, PoP_Module_Processor_ShareModalComponents::COMPONENT_MODAL_EMBED],
                        self::COMPONENT_ANCHORCONTROL_API => [PoP_Module_Processor_ShareModalComponents::class, PoP_Module_Processor_ShareModalComponents::COMPONENT_MODAL_API],
                        self::COMPONENT_ANCHORCONTROL_COPYSEARCHURL => [PoP_Module_Processor_ShareModalComponents::class, PoP_Module_Processor_ShareModalComponents::COMPONENT_MODAL_COPYSEARCHURL],
                    );
                    $modal = $modals[$component->name];
                    return '#'.$componentprocessor_manager->getComponentProcessor($modal)->getFrontendId($modal, $props).'_modal';
            }
        }

        return parent::getHref($component, $props);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_EMBED:
            case self::COMPONENT_ANCHORCONTROL_API:
            case self::COMPONENT_ANCHORCONTROL_COPYSEARCHURL:
                $this->mergeProp(
                    $component,
                    $props,
                    'params',
                    array(
                        'data-toggle' => 'modal',
                        'data-blocktarget' => $this->getProp($component, $props, 'control-target'),
                        'data-target-title' => $this->getProp($component, $props, 'controltarget-title'),
                    )
                );
                break;
        }

        parent::initModelProps($component, $props);
    }
}


