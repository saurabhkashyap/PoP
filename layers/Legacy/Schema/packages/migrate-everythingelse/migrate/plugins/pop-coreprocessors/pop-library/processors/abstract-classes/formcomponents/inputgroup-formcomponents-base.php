<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\ComponentModel\ComponentProcessors\FormComponentComponentProcessorInterface;

abstract class PoP_Module_Processor_InputGroupFormComponentsBase extends PoPEngine_QueryDataComponentProcessorBase implements FormComponentComponentProcessorInterface
{
    use FormComponentModuleDelegatorTrait;

    public function getTemplateResource(array $module, array &$props): ?array
    {
        return [PoP_Forms_TemplateResourceLoaderProcessor::class, PoP_Forms_TemplateResourceLoaderProcessor::RESOURCE_FORMCOMPONENT_INPUTGROUP];
    }

    public function getFormcomponentModule(array $module)
    {
        return $this->getInputSubmodule($module);
    }

    public function getControlSubmodules(array $module)
    {
        return array();
    }
    public function getInputSubmodule(array $module)
    {
        return null;
    }
    public function getInputgroupbtnClass(array $module)
    {
        return '';
    }

    public function getImmutableConfiguration(array $module, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($module, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        $ret[GD_JS_CLASSES]['input-group-btn'] = $this->getInputgroupbtnClass($module);

        $counter = 0;
        $keys = array();
        foreach ($this->getControlSubmodules($module) as $control) {
            $key = 'a'.$counter++;
            $ret[GD_JS_SUBMODULEOUTPUTNAMES][$key] = \PoP\ComponentModel\Facades\Modules\ModuleHelpersFacade::getInstance()->getModuleOutputName($control);
            $keys[] = $key;
        }
        $ret['settings-keys']['controls'] = $keys;

        if ($input = $this->getInputSubmodule($module)) {
            $ret[GD_JS_SUBMODULEOUTPUTNAMES]['input'] = \PoP\ComponentModel\Facades\Modules\ModuleHelpersFacade::getInstance()->getModuleOutputName($input);
        }
        return $ret;
    }

    public function getSubComponentVariations(array $module): array
    {
        $ret = parent::getSubComponentVariations($module);

        if ($input = $this->getInputSubmodule($module)) {
            $ret[] = $input;
        }

        $ret = array_merge(
            $ret,
            $this->getControlSubmodules($module)
        );

        return $ret;
    }

    public function initRequestProps(array $module, array &$props): void
    {
        $this->metaFormcomponentInitModuleRequestProps($module, $props);
        parent::initRequestProps($module, $props);
    }
}
