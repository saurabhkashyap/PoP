<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_ContentCreation_Module_Processor_FormComponentGroups extends PoP_Module_Processor_FormComponentGroupsBase
{
    public final const MODULE_FORMCOMPONENTGROUP_CARD_FLAG = 'formcomponentgroup-card-flag';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMCOMPONENTGROUP_CARD_FLAG],
        );
    }

    public function getComponentSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMCOMPONENTGROUP_CARD_FLAG:
                return [PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_POST];
        }

        return parent::getComponentSubmodule($componentVariation);
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        switch ($componentVariation[1]) {
            case self::MODULE_FORMCOMPONENTGROUP_CARD_FLAG:
                $component = $this->getComponentSubmodule($componentVariation);

                $trigger = $componentprocessor_manager->getProcessor($component)->getTriggerSubmodule($component);
                $description = sprintf(
                    '<em><label><strong>%s</strong></label></em>',
                    TranslationAPIFacade::getInstance()->__('Flag as inappropriate:', 'pop-application-processors')
                );
                $this->setProp($trigger, $props, 'description', $description);
                break;
        }

        parent::initModelProps($componentVariation, $props);
    }

    public function getLabel(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMCOMPONENTGROUP_CARD_FLAG:
                return '';
        }

        return parent::getLabel($componentVariation, $props);
    }
}



