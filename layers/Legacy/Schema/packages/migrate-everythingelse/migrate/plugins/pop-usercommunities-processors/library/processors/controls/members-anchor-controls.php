<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\Engine\Route\RouteUtils;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_URE_Module_Processor_CustomAnchorControls extends PoP_Module_Processor_AnchorControlsBase
{
    public final const COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS = 'anchorcontrol-invitenewmembers';
    public final const COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG = 'anchorcontrol-invitenewmembers-big';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS,
            self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG,
        );
    }

    public function getLabel(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS:
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG:
                return TranslationAPIFacade::getInstance()->__('Invite new members', 'poptheme-wassup');
        }

        return parent::getLabel($component, $props);
    }
    public function getText(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS:
                return null;
        }

        return parent::getText($component, $props);
    }
    public function getFontawesome(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS:
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG:
                return 'fa-user-plus';
        }

        return parent::getFontawesome($component, $props);
    }
    public function getHref(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();

        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS:
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG:
                return RouteUtils::getRouteURL(POP_USERCOMMUNITIES_ROUTE_INVITENEWMEMBERS);
        }

        return parent::getHref($component, $props);
    }

    public function getTarget(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS:
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG:
                return POP_TARGET_MODALS;
        }

        return parent::getTarget($component, $props);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS:
                $this->appendProp($component, $props, 'class', 'btn btn-compact btn-link');
                break;

            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG:
                $this->appendProp($component, $props, 'class', 'btn btn-success btn-important btn-block');
                $this->setProp($component, $props, 'make-title', true);
                break;
        }

        parent::initModelProps($component, $props);
    }

    public function getClasses(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getClasses($component);

        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_INVITENEWMEMBERS_BIG:
                $ret[GD_JS_CLASSES]['text'] = '';
                break;
        }

        return $ret;
    }
}


