<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

abstract class PoP_AddPostLinks_Module_Processor_LinkFrameLayoutsBase extends PoPEngine_QueryDataComponentProcessorBase
{
    public function getTemplateResource(\PoP\ComponentModel\Component\Component $component, array &$props): ?array
    {
        return [PoP_AddPostLinksWebPlatform_TemplateResourceLoaderProcessor::class, PoP_AddPostLinksWebPlatform_TemplateResourceLoaderProcessor::RESOURCE_LAYOUT_LINKFRAME];
    }

    public function getLayoutSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        return null;
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        if ($layout = $this->getLayoutSubcomponent($component)) {
            $ret[] = $layout;
        }

        return $ret;
    }

    /**
     * @todo Migrate from string to LeafComponentFieldNode
     *
     * @return \PoP\ComponentModel\GraphQLEngine\Model\ComponentModelSpec\LeafComponentFieldNode[]
     */
    public function getLeafComponentFieldNodes(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getLeafComponentFieldNodes($component, $props);

        $ret[] = 'link';
        $ret[] = 'isLinkEmbeddable';

        return $ret;
    }

    public function showFrameInCollapse(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return false;
    }

    public function getCollapseClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
    
        // return 'collapse';
        return '';
    }

    public function getLoadlinkBtnClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return 'btn btn-primary';
    }
    public function getOpennewtabBtnClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return 'btn btn-default';
    }
    public function printSource(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return false;
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        if ($this->printSource($component, $props)) {
            $ret['print-source'] = true;
            $ret[GD_JS_TITLES]['source'] = TranslationAPIFacade::getInstance()->__('From external link:', 'pop-addpostlinks-processors');
        }
        if ($this->showFrameInCollapse($component, $props)) {
            $ret['show-frame-in-collapse'] = true;
            $ret[GD_JS_CLASSES]['collapse'] = $this->getCollapseClass($component, $props);
            $ret[GD_JS_CLASSES]['loadlink-btn'] = $this->getLoadlinkBtnClass($component, $props);
            $ret[GD_JS_TITLES]['loadlink'] = TranslationAPIFacade::getInstance()->__('Load link', 'pop-addpostlinks-processors');
        }
        $ret[GD_JS_CLASSES]['opennewtab-btn'] = $this->getOpennewtabBtnClass($component, $props);
        $ret[GD_JS_TITLES]['opennewtab'] = TranslationAPIFacade::getInstance()->__('Open link in new tab', 'pop-addpostlinks-processors');

        if ($layout = $this->getLayoutSubcomponent($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['layout'] = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($layout);
        }
        
        return $ret;
    }

    // function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props) {

    //     if ($this->showFrameInCollapse($component, $props)) {

    //         $this->appendProp($component, $props, 'class', $this->getCollapseClass($component, $props));
    //     }
    //     parent::initModelProps($component, $props);
    // }
}
