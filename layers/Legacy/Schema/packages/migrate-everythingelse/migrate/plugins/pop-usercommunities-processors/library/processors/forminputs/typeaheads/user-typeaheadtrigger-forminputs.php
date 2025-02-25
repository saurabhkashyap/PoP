<?php

class GD_URE_Module_Processor_UserSelectableTypeaheadAlertFormComponents extends PoP_Module_Processor_UserSelectableTypeaheadAlertFormComponentsBase
{
    public final const COMPONENT_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_USERCOMMUNITIES = 'formcomponent-selectabletypeaheadalert-usercommunities';
    public final const COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEADALERT_COMMUNITIES = 'filtercomponent-selectabletypeaheadalert-communities';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_USERCOMMUNITIES,
            self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEADALERT_COMMUNITIES,
        );
    }
    
    public function getHiddenInputComponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_USERCOMMUNITIES:
                return [GD_URE_Processor_SelectableHiddenInputFormInputs::class, GD_URE_Processor_SelectableHiddenInputFormInputs::COMPONENT_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTUSERCOMMUNITIES];

            case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEADALERT_COMMUNITIES:
                return [GD_URE_Processor_SelectableHiddenInputFormInputs::class, GD_URE_Processor_SelectableHiddenInputFormInputs::COMPONENT_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTCOMMUNITIES];
        }

        return parent::getHiddenInputComponent($component);
    }

    public function isMultiple(\PoP\ComponentModel\Component\Component $component): bool
    {
        switch ($component->name) {
            case self::COMPONENT_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_USERCOMMUNITIES:
            case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEADALERT_COMMUNITIES:
                return true;
        }

        return parent::isMultiple($component);
    }

    public function getAlertClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getAlertClass($component, $props);

        switch ($component->name) {
            case self::COMPONENT_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_USERCOMMUNITIES:
                $ret .= ' alert-narrow';
                break;
        }

        return $ret;
    }
}



