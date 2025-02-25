<?php

class PoP_Events_Module_Processor_EmailFormGroups extends PoP_Module_Processor_NoLabelFormComponentGroupsBase
{
    public final const COMPONENT_FORMINPUTGROUP_EMAILDIGESTS_WEEKLYUPCOMINGEVENTS = 'forminputgroup-emaildigests-weeklyupcomingevents';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FORMINPUTGROUP_EMAILDIGESTS_WEEKLYUPCOMINGEVENTS,
        );
    }

    public function getComponentSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $components = array(
            self::COMPONENT_FORMINPUTGROUP_EMAILDIGESTS_WEEKLYUPCOMINGEVENTS => [PoP_Events_Module_Processor_UserProfileCheckboxFormInputs::class, PoP_Events_Module_Processor_UserProfileCheckboxFormInputs::COMPONENT_FORMINPUT_EMAILDIGESTS_WEEKLYUPCOMINGEVENTS],
        );

        if ($component = $components[$component->name] ?? null) {
            return $component;
        }

        return parent::getComponentSubcomponent($component);
    }

    public function useModuleConfiguration(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FORMINPUTGROUP_EMAILDIGESTS_WEEKLYUPCOMINGEVENTS:
                return false;
        }

        return parent::useModuleConfiguration($component);
    }
}



