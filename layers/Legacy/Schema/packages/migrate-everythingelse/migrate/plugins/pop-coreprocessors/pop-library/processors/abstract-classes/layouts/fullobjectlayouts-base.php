<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

abstract class PoP_Module_Processor_FullObjectLayoutsBase extends PoPEngine_QueryDataComponentProcessorBase
{
    public function getSidebarSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        return null;
    }

    public function getTitleSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        return null;
    }

    /**
     * @todo Migrate from string to LeafComponentFieldNode
     *
     * @return \PoP\ComponentModel\GraphQLEngine\Model\ComponentModelSpec\LeafComponentFieldNode[]
     */
    public function getLeafComponentFieldNodes(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        return array_merge(
            parent::getLeafComponentFieldNodes($component, $props),
            array('url')
        );
    }

    public function getHeaderSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }

    public function getFooterSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }

    public function getFullviewFooterSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {

        // Allow 3rd parties to modify the modules. Eg: for the TPP website we re-use the MESYM Theme but we modify some of its elements, eg: adding the "What do you think about TPP?" modules in the fullview templates
        return \PoP\Root\App::applyFilters('PoP_Module_Processor_FullObjectLayoutsBase:footer_components', $this->getFooterSubcomponents($component), $component);
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        if ($title = $this->getTitleSubcomponent($component)) {
            $ret[] = $title;
        }
        if ($sidebar = $this->getSidebarSubcomponent($component)) {
            $ret[] = $sidebar;
        }
        if ($headers = $this->getHeaderSubcomponents($component)) {
            $ret = array_merge(
                $ret,
                $headers
            );
        }
        if ($footers = $this->getFullviewFooterSubcomponents($component)) {
            $ret = array_merge(
                $ret,
                $footers
            );
        }

        return $ret;
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        $ret = parent::getImmutableConfiguration($component, $props);

        $ret[GD_JS_CLASSES] = array(
            'wrapper' => '',
            'inner-wrapper' => 'row',
            'socialmedia' => '',
            'content' => 'readable clearfix',
            'sidebar' => '',
            'content-body' => 'col-xs-12'

        );

        if ($title = $this->getTitleSubcomponent($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['title'] = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($title);
        }
        if ($sidebar = $this->getSidebarSubcomponent($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['sidebar'] = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($sidebar);
            $ret[GD_JS_CLASSES]['sidebar'] = 'col-xsm-3 col-xsm-push-9';
            $ret[GD_JS_CLASSES]['content-body'] = 'col-xsm-9 col-xsm-pull-3';
        }
        if ($headers = $this->getHeaderSubcomponents($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['headers'] = array_map(
                \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName(...), 
                $headers
            );
        }
        if ($footers = $this->getFullviewFooterSubcomponents($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['footers'] = array_map(
                \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName(...), 
                $footers
            );
        }
        
        return $ret;
    }
}
