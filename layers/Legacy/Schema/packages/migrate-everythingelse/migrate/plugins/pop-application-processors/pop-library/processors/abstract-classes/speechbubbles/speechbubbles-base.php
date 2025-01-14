<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

abstract class PoP_Module_Processor_SpeechBubblesBase extends PoPEngine_QueryDataComponentProcessorBase
{
    public function getTemplateResource(\PoP\ComponentModel\Component\Component $component, array &$props): ?array
    {
        return [PoP_ApplicationProcessors_TemplateResourceLoaderProcessor::class, PoP_ApplicationProcessors_TemplateResourceLoaderProcessor::RESOURCE_SPEECHBUBBLE];
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

        $ret[] = $this->getLayoutSubcomponent($component);
        
        return $ret;
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);
    
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        
        $ret[GD_JS_CLASSES] = array(
            'bubble-wrapper' => '',
            'bubble' => 'speechbubble'
        );
        
        $layout = $this->getLayoutSubcomponent($component);
        $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['layout'] = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($layout);
        
        return $ret;
    }
}
