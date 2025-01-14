<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

abstract class PoP_Module_Processor_PanelBootstrapComponentsBase extends PoP_Module_Processor_BootstrapComponentsBase
{
    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        return array_merge(
            parent::getSubcomponents($component),
            $this->getPanelSubcomponents($component)
        );
    }

    public function getPanelSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }

    public function getButtons(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }
    public function getBodyClass(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }
    public function getIcon(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }

    public function getPanelParams(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return array();
    }

    public function getCustomPanelClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return array();
    }
    public function getPanelClass(\PoP\ComponentModel\Component\Component $component)
    {
        return '';
    }
    public function getCustomPanelParams(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = array();

        // $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        // foreach ($this->getSubcomponents($component) as $subcomponent) {

        //     $subcomponentOutputName = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($subcomponent);
        //     $frontend_id = PoP_Bootstrap_Utils::getFrontendId($this->getFrontendId($component, $props), $this->getBootstrapcomponentType($component));
        //     $ret[$subcomponentOutputName]['data-initjs-targets'] = sprintf(
        //         '%s > %s',
        //         '#'.$frontend_id.'-'.$subcomponentOutputName.'-container',
        //         'div.pop-block'
        //     );
        // }

        return $ret;
    }

    public function getPanelactiveClass(\PoP\ComponentModel\Component\Component $component)
    {
        return '';
    }

    // protected function getInitjsBlockbranches(\PoP\ComponentModel\Component\Component $component, array &$props) {

    //     return array_merge(
    //         parent::getInitjsBlockbranches($component, $props),
    //         $this->getActivemoduleSelectors($component, $props)
    //     );
    // }

    // function getActivemoduleSelectors(\PoP\ComponentModel\Component\Component $component, array &$props) {

    //     $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

    //     $ret = array();

    //     foreach ($this->getSubcomponents($component) as $subcomponent) {

    //         $subcomponentOutputName = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($subcomponent);
    //         $frontend_id = PoP_Bootstrap_Utils::getFrontendId(/*$props['block-id']*/$this->getFrontendId($component, $props), $this->getBootstrapcomponentType($component));
    //         $ret[] = sprintf(
    //             '%s > %s > %s',
    //             '#'.$frontend_id.'-'.$subcomponentOutputName.'.'.$this->getPanelactiveClass($component),
    //             '#'.$frontend_id.'-'.$subcomponentOutputName.'-container',
    //             'div.pop-block'
    //         );
    //     }

    //     return $ret;
    // }

    public function getButtonsClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return array();
    }

    public function isSubcomponentActivePanel(\PoP\ComponentModel\Component\Component $component, $subcomponent)
    {
        return false;
    }
    public function getActivepanelSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $subcomponents = $this->getSubcomponents($component);
        foreach ($subcomponents as $subcomponent) {
            if ($this->isSubcomponentActivePanel($component, $subcomponent)) {
                return $subcomponent;
            }
        }

        if ($this->isMandatoryActivePanel($component)) {
            return $this->getDefaultActivepanelSubcomponent($component);
        }

        return null;
    }
    protected function isMandatoryActivePanel(\PoP\ComponentModel\Component\Component $component)
    {
        return false;
    }

    public function getDefaultActivepanelSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {

        // Simply return the first one
        $subcomponents = $this->getSubcomponents($component);
        return $subcomponents[0];
    }

    public function getPanelTitle(\PoP\ComponentModel\Component\Component $component)
    {
        return null;
    }
    public function getPanelHeaderType(\PoP\ComponentModel\Component\Component $component)
    {
        return null;
    }
    public function getDropdownTitle(\PoP\ComponentModel\Component\Component $component)
    {
        return null;
    }

    public function getPanelHeaders(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = array();

        foreach ($this->getSubcomponents($component) as $subcomponent) {
            $ret[] = [
                'header-subcomponent' => $subcomponent,
            ];
        }

        return $ret;
    }

    public function getPanelHeaderThumbs(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return null;
    }
    public function getPanelHeaderTooltips(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return null;
    }
    public function getPanelHeaderTitles(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        // Comment Leo 19/11/2018: Check this out: initially, this gets the title from the block, but since migrating blocks to dataloads, the processor may not have `getTitle` anymore and the code below explodes
        // $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        // return $componentprocessor_manager->getComponentProcessor($subcomponent)->getTitle($subcomponent, $props);
        return array();
    }
    public function getPanelheaderClass(\PoP\ComponentModel\Component\Component $component)
    {
        return '';
    }
    public function getPanelheaderItemClass(\PoP\ComponentModel\Component\Component $component)
    {
        return '';
    }
    public function getPanelheaderParams(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }

    public function getJsmethods(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getJsmethods($component, $props);

        if ($this->getPanelHeaderTooltips($component, $props)) {
            $this->addJsmethod($ret, 'tooltip', 'tooltip');
        }

        return $ret;
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        if ($panel_components = $this->getPanelSubcomponents($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['panels'] = array_map(
                \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName(...),
                $panel_components
            );
        }

        // Fill in all the properties
        if ($panel_header_type = $this->getPanelHeaderType($component)) {
            $ret['panel-header-type'] = $panel_header_type;
            $ret['panel-title'] = $this->getPanelTitle($component);

            $titles = $this->getPanelHeaderTitles($component, $props);
            $thumbs = $this->getPanelHeaderThumbs($component, $props);
            $tooltips = $this->getPanelHeaderTooltips($component, $props);

            $panel_headers = array();
            foreach ($this->getPanelHeaders($component, $props) as $panelHeader) {
                $header_subcomponent = $panelHeader['header-subcomponent'];
                $subheader_subcomponents = $panelHeader['subheader-subcomponents'];
                $headerSubcomponentFullName = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentFullName($header_subcomponent);
                $header = array(
                    'componentoutputname' => \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($header_subcomponent)
                );
                if ($title = $titles[$headerSubcomponentFullName] ?? null) {
                    $header['title'] = $title;
                }
                if ($thumb = $thumbs[$headerSubcomponentFullName] ?? null) {
                    $header['fontawesome'] = $thumb;
                }
                if ($tooltip = $tooltips[$headerSubcomponentFullName] ?? null) {
                    $header['tooltip'] = $tooltip;
                }

                if ($subheader_subcomponents) {
                    $subheaders = array();
                    foreach ($subheader_subcomponents as $subheader_subcomponent) {
                        $subheaderSubcomponentFullName = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentFullName($subheader_subcomponent);
                        $subheader = array(
                            'componentoutputname' => \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($subheader_subcomponent)
                        );
                        if ($title = $titles[$subheaderSubcomponentFullName] ?? null) {
                            $subheader['title'] = $title;
                        }
                        if ($thumb = $thumbs[$subheaderSubcomponentFullName] ?? null) {
                            $subheader['fontawesome'] = $thumb;
                        }
                        if ($tooltip = $tooltips[$subheaderSubcomponentFullName] ?? null) {
                            $subheader['tooltip'] = $tooltip;
                        }
                        $subheaders[] = $subheader;
                    }

                    $header['subheaders'] = $subheaders;
                }

                $panel_headers[] = $header;
            }
            $ret['panel-headers'] = $panel_headers;

            if ($panelheader_class = $this->getPanelheaderClass($component)) {
                $ret[GD_JS_CLASSES]['panelheader'] = $panelheader_class;
            }
            if ($panelheader_item_class = $this->getPanelheaderItemClass($component)) {
                $ret[GD_JS_CLASSES]['panelheader-item'] = $panelheader_item_class;
            }
            if ($panelheader_params = $this->getPanelheaderParams($component)) {
                $ret['panelheader-params'] = $panelheader_params;
            }
        }

        if ($dropdown_title = $this->getDropdownTitle($component)) {
            $ret[GD_JS_TITLES] = array(
                'dropdown' => $dropdown_title
            );
        }

        if ($buttons_class = $this->getButtonsClass($component, $props)) {
            $ret['buttons-class'] = $buttons_class;
        }
        if ($panel_class = $this->getPanelClass($component)) {
            $ret[GD_JS_CLASSES]['panel'] = $panel_class;
        }
        if ($custom_panel_class = $this->getCustomPanelClass($component, $props)) {
            $ret['custom-panel-class'] = $custom_panel_class;
        }
        if ($panel_params = $this->getPanelParams($component, $props)) {
            $ret['panel-params'] = $panel_params;
        }
        if ($custom_panel_params = $this->getCustomPanelParams($component, $props)) {
            $ret['custom-panel-params'] = $custom_panel_params;
        }
        if ($icon = $this->getIcon($component)) {
            $ret['icon'] = $icon;
        }
        if ($body_class = $this->getBodyClass($component)) {
            $ret['body-class'] = $body_class;
        }
        $ret['buttons'] = $this->getButtons($component);

        return $ret;
    }

    public function getMutableonmodelConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getMutableonmodelConfiguration($component, $props);

        if ($active_subcomponent = $this->getActivepanelSubcomponent($component)) {
            $ret['active'] = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($active_subcomponent);
        }

        return $ret;
    }

    protected function lazyLoadInactivePanels(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return false;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        if ($this->lazyLoadInactivePanels($component, $props)) {
            $active_subcomponent = $this->getActivepanelSubcomponent($component);
            $inactive_subcomponents = array_diff(
                $this->getSubcomponents($component),
                array(
                    $active_subcomponent
                )
            );
            foreach ($inactive_subcomponents as $subcomponent) {
                $this->setProp([$subcomponent], $props, 'skip-data-load', true);
            }
        }

        parent::initModelProps($component, $props);
    }

    // function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props) {

    //     $blocktarget = implode(', ', $this->getActivemoduleSelectors($component, $props));
    //     if ($controlgroup_top = $this->getControlgroupTopSubcomponent($component)) {
    //         $this->setProp($controlgroup_top, $props, 'control-target', $blocktarget);
    //     }
    //     if ($controlgroup_bottom = $this->getControlgroupBottomSubcomponent($component)) {
    //         $this->setProp($controlgroup_bottom, $props, 'control-target', $blocktarget);
    //     }

    //     parent::initModelProps($component, $props);
    // }
}
