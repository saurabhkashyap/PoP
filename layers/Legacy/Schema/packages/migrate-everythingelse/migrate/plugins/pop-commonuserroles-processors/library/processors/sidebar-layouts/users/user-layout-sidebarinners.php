<?php

class GD_URE_Module_Processor_CustomUserLayoutSidebarInners extends PoP_Module_Processor_SidebarInnersBase
{
    public final const COMPONENT_LAYOUT_USERSIDEBARINNER_VERTICAL_ORGANIZATION = 'layout-usersidebarinner-vertical-organization';
    public final const COMPONENT_LAYOUT_USERSIDEBARINNER_VERTICAL_INDIVIDUAL = 'layout-usersidebarinner-vertical-individual';
    public final const COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_ORGANIZATION = 'layout-usersidebarinner-horizontal-organization';
    public final const COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_INDIVIDUAL = 'layout-usersidebarinner-horizontal-individual';
    public final const COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_ORGANIZATION = 'layout-usersidebarinner-compacthorizontal-organization';
    public final const COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_INDIVIDUAL = 'layout-usersidebarinner-compacthorizontal-individual';
    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUT_USERSIDEBARINNER_VERTICAL_ORGANIZATION,
            self::COMPONENT_LAYOUT_USERSIDEBARINNER_VERTICAL_INDIVIDUAL,
            self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_ORGANIZATION,
            self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_INDIVIDUAL,
            self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_ORGANIZATION,
            self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_INDIVIDUAL,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getLayoutSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_ORGANIZATION:
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_VERTICAL_ORGANIZATION:
                $ret = array_merge(
                    $ret,
                    URE_FullUserSidebarSettings::getSidebarSubcomponents(GD_SIDEBARSECTION_ORGANIZATION)
                );
                break;

            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_INDIVIDUAL:
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_VERTICAL_INDIVIDUAL:
                $ret = array_merge(
                    $ret,
                    URE_FullUserSidebarSettings::getSidebarSubcomponents(GD_SIDEBARSECTION_INDIVIDUAL)
                );
                break;

            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_ORGANIZATION:
                $ret = array_merge(
                    $ret,
                    URE_FullUserSidebarSettings::getSidebarSubcomponents(GD_COMPACTSIDEBARSECTION_ORGANIZATION)
                );
                break;

            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_INDIVIDUAL:
                $ret = array_merge(
                    $ret,
                    URE_FullUserSidebarSettings::getSidebarSubcomponents(GD_COMPACTSIDEBARSECTION_INDIVIDUAL)
                );
                break;
        }
        
        return $ret;
    }

    public function getWrapperClass(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_ORGANIZATION:
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_INDIVIDUAL:
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_ORGANIZATION:
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_INDIVIDUAL:
                return 'row';
        }
    
        return parent::getWrapperClass($component);
    }
    
    public function getWidgetwrapperClass(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_ORGANIZATION:
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_HORIZONTAL_INDIVIDUAL:
                return 'col-xsm-4';

            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_ORGANIZATION:
            case self::COMPONENT_LAYOUT_USERSIDEBARINNER_COMPACTHORIZONTAL_INDIVIDUAL:
                return 'col-xsm-6';
        }
    
        return parent::getWidgetwrapperClass($component);
    }
}



