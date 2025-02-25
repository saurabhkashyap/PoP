<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_URE_Module_Processor_ProfileFormGroups extends PoP_Module_Processor_FormComponentGroupsBase
{
    public final const COMPONENT_URE_FORMINPUTGROUP_MEMBERPRIVILEGES = 'ure-forminputgroup-memberprivileges';
    public final const COMPONENT_URE_FORMINPUTGROUP_MEMBERTAGS = 'ure-forminputgroup-membertags';
    public final const COMPONENT_URE_FORMINPUTGROUP_MEMBERSTATUS = 'ure-forminputgroup-memberstatus';
    public final const COMPONENT_URE_FILTERINPUTGROUP_MEMBERPRIVILEGES = 'ure-filterinputgroup-memberprivileges';
    public final const COMPONENT_URE_FILTERINPUTGROUP_MEMBERTAGS = 'ure-filterinputgroup-membertags';
    public final const COMPONENT_URE_FILTERINPUTGROUP_MEMBERSTATUS = 'ure-filterinputgroup-memberstatus';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_URE_FORMINPUTGROUP_MEMBERPRIVILEGES,
            self::COMPONENT_URE_FORMINPUTGROUP_MEMBERTAGS,
            self::COMPONENT_URE_FORMINPUTGROUP_MEMBERSTATUS,
            self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERPRIVILEGES,
            self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERTAGS,
            self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERSTATUS,
        );
    }

    public function getLabelClass(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getLabelClass($component);

        switch ($component->name) {
            case self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERPRIVILEGES:
            case self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERTAGS:
            case self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERSTATUS:
                $ret .= ' col-sm-2';
                break;
        }

        return $ret;
    }
    public function getFormcontrolClass(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getFormcontrolClass($component);

        switch ($component->name) {
            case self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERPRIVILEGES:
            case self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERTAGS:
            case self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERSTATUS:
                $ret .= ' col-sm-10';
                break;
        }

        return $ret;
    }

    public function getComponentSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $components = array(
            self::COMPONENT_URE_FORMINPUTGROUP_MEMBERPRIVILEGES => [GD_URE_Module_Processor_ProfileMultiSelectFormInputs::class, GD_URE_Module_Processor_ProfileMultiSelectFormInputs::COMPONENT_URE_FORMINPUT_MEMBERPRIVILEGES],
            self::COMPONENT_URE_FORMINPUTGROUP_MEMBERTAGS => [GD_URE_Module_Processor_ProfileMultiSelectFormInputs::class, GD_URE_Module_Processor_ProfileMultiSelectFormInputs::COMPONENT_URE_FORMINPUT_MEMBERTAGS],
            self::COMPONENT_URE_FORMINPUTGROUP_MEMBERSTATUS => [GD_URE_Module_Processor_SelectFormInputs::class, GD_URE_Module_Processor_SelectFormInputs::COMPONENT_URE_FORMINPUT_MEMBERSTATUS],
            self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERPRIVILEGES => [GD_URE_Module_Processor_ProfileMultiSelectFilterInputs::class, GD_URE_Module_Processor_ProfileMultiSelectFilterInputs::COMPONENT_URE_FILTERINPUT_MEMBERPRIVILEGES],
            self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERTAGS => [GD_URE_Module_Processor_ProfileMultiSelectFilterInputs::class, GD_URE_Module_Processor_ProfileMultiSelectFilterInputs::COMPONENT_URE_FILTERINPUT_MEMBERTAGS],
            self::COMPONENT_URE_FILTERINPUTGROUP_MEMBERSTATUS => [GD_URE_Module_Processor_ProfileMultiSelectFilterInputs::class, GD_URE_Module_Processor_ProfileMultiSelectFilterInputs::COMPONENT_URE_FILTERINPUT_MEMBERSTATUS],
        );

        if ($component = $components[$component->name] ?? null) {
            return $component;
        }

        return parent::getComponentSubcomponent($component);
    }

    public function getInfo(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_URE_FORMINPUTGROUP_MEMBERSTATUS:
                return TranslationAPIFacade::getInstance()->__('Status "Active" if the user is truly your member, or "Rejected" otherwise. Rejected users will not appear as your community\'s members, or contribute content.');

            case self::COMPONENT_URE_FORMINPUTGROUP_MEMBERPRIVILEGES:
                return TranslationAPIFacade::getInstance()->__('"Contribute content" will add the member\'s content to your profile.', 'ure-popprocessors');

            case self::COMPONENT_URE_FORMINPUTGROUP_MEMBERTAGS:
                return TranslationAPIFacade::getInstance()->__('What is the type of relationship from this member to your community.', 'ure-popprocessors');
        }

        return parent::getInfo($component, $props);
    }
}



