<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

abstract class PoP_Module_Processor_ScrollsBase extends PoP_Module_Processor_StructuresBase
{
    public function getTemplateResource(\PoP\ComponentModel\Component\Component $component, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_SCROLL];
    }

    protected function getDescription(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return null;
    }

    public function getFetchmoreButtonSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        return [PoP_Module_Processor_FetchMore::class, PoP_Module_Processor_FetchMore::COMPONENT_FETCHMORE];
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        if ($fetchmore = $this->getFetchmoreButtonSubcomponent($component)) {
            $ret[] = $fetchmore;
        }

        return $ret;
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        if ($this->useFetchmore($component, $props)) {
            $fetchmore = $this->getFetchmoreButtonSubcomponent($component);
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['fetchmore'] = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($fetchmore);
        }
        if ($description = $this->getProp($component, $props, 'description')) {
            $ret[GD_JS_DESCRIPTION] = $description;
        }
        if ($inner_class = $this->getProp($component, $props, 'inner-class')) {
            $ret[GD_JS_CLASSES]['inner'] = $inner_class;
        }

        return $ret;
    }

    protected function useFetchmore(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return $this->getFetchmoreButtonSubcomponent($component) && $this->getProp($component, $props, 'show-fetchmore');
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        $this->setProp($component, $props, 'show-fetchmore', true);
        $this->setProp($component, $props, 'description', $this->getDescription($component, $props));
        parent::initModelProps($component, $props);
    }
}
