<?php

class GD_Custom_Module_Processor_UserMultipleSidebarComponents extends PoP_Module_Processor_MultiplesBase
{
    public final const COMPONENT_SIDEBARMULTICOMPONENT_GENERICUSER = 'sidebarmulticomponent-genericuser';
    public final const COMPONENT_SIDEBARMULTICOMPONENT_AVATAR = 'sidebarmulticomponent-avatar';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_SIDEBARMULTICOMPONENT_GENERICUSER,
            self::COMPONENT_SIDEBARMULTICOMPONENT_AVATAR,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_SIDEBARMULTICOMPONENT_GENERICUSER:
                $ret[] = [PoP_Module_Processor_CustomPostWidgets::class, GD_Custom_Module_Processor_UserWidgets::COMPONENT_WIDGETCOMPACT_GENERICUSERINFO];
                break;

            case self::COMPONENT_SIDEBARMULTICOMPONENT_AVATAR:
                if (defined('POP_AVATARPROCESSORS_INITIALIZED')) {
                    $ret[] = [PoP_Module_Processor_UserPhotoLayouts::class, PoP_Module_Processor_UserPhotoLayouts::COMPONENT_LAYOUT_AUTHOR_USERPHOTO];
                }
                $ret[] = [PoP_Module_Processor_SocialMedia::class, PoP_Module_Processor_SocialMedia::COMPONENT_USERSOCIALMEDIA];
                break;
        }

        return $ret;
    }
}



