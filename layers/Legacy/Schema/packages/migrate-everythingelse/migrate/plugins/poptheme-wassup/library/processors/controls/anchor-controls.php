<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_Wassup_Module_Processor_AnchorControls extends PoP_Module_Processor_AnchorControlsBase
{
    public final const COMPONENT_ANCHORCONTROL_TOGGLEQUICKVIEWINFO = 'anchorcontrol-togglequickviewinfo';
    public final const COMPONENT_ANCHORCONTROL_TOGGLESIDEINFO = 'anchorcontrol-togglesideinfo';
    public final const COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS = 'anchorcontrol-togglesideinfoxs';
    public final const COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK = 'anchorcontrol-togglesideinfoxs-back';
    public final const COMPONENT_ANCHORCONTROL_TOGGLETABS = 'anchorcontrol-toggletabs';
    public final const COMPONENT_ANCHORCONTROL_TOGGLETABSXS = 'anchorcontrol-toggletabsxs';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_ANCHORCONTROL_TOGGLEQUICKVIEWINFO,
            self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFO,
            self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS,
            self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK,
            self::COMPONENT_ANCHORCONTROL_TOGGLETABS,
            self::COMPONENT_ANCHORCONTROL_TOGGLETABSXS,
        );
    }

    public function getLabel(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_TOGGLEQUICKVIEWINFO:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFO:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS:
                return TranslationAPIFacade::getInstance()->__('Toggle sidebar', 'pop-coreprocessors');

            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK:
                return TranslationAPIFacade::getInstance()->__('Go back', 'pop-coreprocessors');

            case self::COMPONENT_ANCHORCONTROL_TOGGLETABS:
            case self::COMPONENT_ANCHORCONTROL_TOGGLETABSXS:
                return TranslationAPIFacade::getInstance()->__('Toggle tabs', 'pop-coreprocessors');
        }

        return parent::getLabel($component, $props);
    }
    public function getText(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK:
                return null;
        }

        return parent::getText($component, $props);
    }
    public function getIcon(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_TOGGLEQUICKVIEWINFO:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFO:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS:
                return 'glyphicon-arrow-right';

            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK:
                return 'glyphicon-arrow-left';

            case self::COMPONENT_ANCHORCONTROL_TOGGLETABS:
            case self::COMPONENT_ANCHORCONTROL_TOGGLETABSXS:
                return 'glyphicon-time';
        }

        return parent::getIcon($component);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_TOGGLEQUICKVIEWINFO:
                $this->mergeProp(
                    $component,
                    $props,
                    'params',
                    array(
                        'data-toggle' => 'offcanvas-toggle',
                        'data-target' => '#'.POP_COMPONENTID_PAGESECTIONCONTAINERID_QUICKVIEWSIDEINFO,
                    )
                );
                break;

            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFO:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK:
                $mode = '';
                $classs = '';
                $xs = array(
                    self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS,
                    self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK,
                );
                $tablet = array(
                    self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFO,
                );
                if (in_array($component, $xs)) {
                    $mode = 'xs';
                    $classs = 'hidden-sm hidden-md hidden-lg';
                } elseif (in_array($component, $tablet)) {
                    $classs = 'hidden-xs';
                }

                $back = array(
                    self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK,
                );
                if (in_array($component, $back)) {
                    $classs .= ' btn btn-lg btn-link';
                }

                $this->appendProp($component, $props, 'class', $classs);
                $this->mergeProp(
                    $component,
                    $props,
                    'params',
                    array(
                        'data-toggle' => 'offcanvas-toggle',
                        'data-target' => '#'.POP_COMPONENTID_PAGESECTIONCONTAINERID_BODYSIDEINFO,
                        'data-mode' => $mode,
                    )
                );
                break;

            case self::COMPONENT_ANCHORCONTROL_TOGGLETABS:
            case self::COMPONENT_ANCHORCONTROL_TOGGLETABSXS:
                $xs = array(
                    self::COMPONENT_ANCHORCONTROL_TOGGLETABSXS,
                );
                if (in_array($component, $xs)) {
                    $mode = 'xs';
                    $classs = 'hidden-sm hidden-md hidden-lg';
                } else {
                    $mode = '';
                    $classs = 'hidden-xs';
                }
                $this->appendProp($component, $props, 'class', $classs);
                $this->mergeProp(
                    $component,
                    $props,
                    'params',
                    array(
                        'data-toggle' => 'offcanvas-toggle',
                        'data-target' => '#'.POP_COMPONENTID_PAGESECTIONCONTAINERID_BODYTABS,
                        'data-mode' => $mode,
                    )
                );
                break;
        }

        parent::initModelProps($component, $props);
    }

    public function getJsmethods(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getJsmethods($component, $props);

        switch ($component->name) {
            case self::COMPONENT_ANCHORCONTROL_TOGGLEQUICKVIEWINFO:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFO:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS:
            case self::COMPONENT_ANCHORCONTROL_TOGGLESIDEINFOXS_BACK:
            case self::COMPONENT_ANCHORCONTROL_TOGGLETABS:
            case self::COMPONENT_ANCHORCONTROL_TOGGLETABSXS:
                $this->addJsmethod($ret, 'offcanvasToggle');
                break;
        }
        return $ret;
    }
}


