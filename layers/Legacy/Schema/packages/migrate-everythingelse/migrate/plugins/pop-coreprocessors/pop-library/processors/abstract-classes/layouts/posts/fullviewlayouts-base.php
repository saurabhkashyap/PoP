<?php
define('GD_CONSTANT_FULLVIEW_TITLEPOSITION_TOP', 'top');
define('GD_CONSTANT_FULLVIEW_TITLEPOSITION_BODY', 'body');

use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

abstract class PoP_Module_Processor_FullViewLayoutsBase extends PoP_Module_Processor_FullObjectLayoutsBase
{
    public function getTemplateResource(\PoP\ComponentModel\Component\Component $component, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_LAYOUT_FULLVIEW];
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
            array('catSlugs')
        );
    }

    public function titlePosition(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return GD_CONSTANT_FULLVIEW_TITLEPOSITION_TOP;
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        if ($abovecontent_components = $this->getAbovecontentSubcomponents($component)) {
            $ret = array_merge(
                $ret,
                $abovecontent_components
            );
        }

        if ($content_components = $this->getContentSubcomponents($component)) {
            $ret = array_merge(
                $ret,
                $content_components
            );
        }

        return $ret;
    }

    public function getAbovecontentSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        return array();
    }

    public function getContentSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        return array(
            [PoP_Module_Processor_ContentLayouts::class, PoP_Module_Processor_ContentLayouts::COMPONENT_LAYOUT_CONTENT_POSTFEED],
        );
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        $ret[GD_JS_CLASSES]['title'] = '';

        if ($this->getTitleSubcomponent($component, $props)) {
            $ret['title-position'] = $this->titlePosition($component, $props);
        }

        if ($abovecontent_components = $this->getAbovecontentSubcomponents($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['abovecontent'] = array_map(
                \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName(...),
                $abovecontent_components
            );
        }

        if ($content_components = $this->getContentSubcomponents($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['content'] = array_map(
                \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName(...),
                $content_components
            );
        }

        return $ret;
    }

    // function getJsmethods(\PoP\ComponentModel\Component\Component $component, array &$props) {

    //     $ret = parent::getJsmethods($component, $props);
    //     $this->addJsmethod($ret, 'waypointsHistoryStateNew');
    //     return $ret;
    // }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {

        // Make it waypoint
        $this->appendProp($component, $props, 'class', 'waypoint');

        // This one is independent of Waypoint because of the History, so here add them as separate instructions (just to make it clear)
        // $this->appendProp($component, $props, 'class', 'module-historystate newstate');
        parent::initModelProps($component, $props);
    }
}
