<?php

class PoP_Events_SocialNetwork_Module_Processor_SidebarMultiples extends PoP_Module_Processor_SidebarMultiplesBase
{
    public final const COMPONENT_MULTIPLE_SINGLE_EVENT_RECOMMENDEDBYSIDEBAR = 'multiple-single-event-recommendedbysidebar';
    public final const COMPONENT_MULTIPLE_SINGLE_PASTEVENT_RECOMMENDEDBYSIDEBAR = 'multiple-single-pastevent-recommendedbysidebar';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_MULTIPLE_SINGLE_EVENT_RECOMMENDEDBYSIDEBAR,
            self::COMPONENT_MULTIPLE_SINGLE_PASTEVENT_RECOMMENDEDBYSIDEBAR,
        );
    }

    public function getInnerSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        switch ($component->name) {
         // Add also the filter block for the Single Related Content, etc
            case self::COMPONENT_MULTIPLE_SINGLE_EVENT_RECOMMENDEDBYSIDEBAR:
                // Comment Leo 27/07/2016: can't have the filter for "POSTAUTHORSSIDEBAR", because to get the authors we do:
                // $ret['include'] = gdGetPostauthors($post_id); (in function addDataloadqueryargsSingleauthors)
                // and the include cannot be filtered. Once it's there, it's final.
                // (And also, it doesn't look so nice to add the filter for the authors, since most likely there is always only 1 author!)
                $filters = array(
                    self::COMPONENT_MULTIPLE_SINGLE_EVENT_RECOMMENDEDBYSIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::COMPONENT_MULTIPLE_SECTIONINNER_USERS_SIDEBAR],
                );
                $ret[] = $filters[$component->name];
                $ret[] = [PoP_Events_Module_Processor_CustomSidebarDataloads::class, PoP_Events_Module_Processor_CustomSidebarDataloads::COMPONENT_DATALOAD_SINGLE_EVENT_SIDEBAR];
                break;

            case self::COMPONENT_MULTIPLE_SINGLE_PASTEVENT_RECOMMENDEDBYSIDEBAR:
                $filters = array(
                    self::COMPONENT_MULTIPLE_SINGLE_PASTEVENT_RECOMMENDEDBYSIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::COMPONENT_MULTIPLE_SECTIONINNER_USERS_SIDEBAR],
                );
                $ret[] = $filters[$component->name];
                $ret[] = [PoP_Events_Module_Processor_CustomSidebarDataloads::class, PoP_Events_Module_Processor_CustomSidebarDataloads::COMPONENT_DATALOAD_SINGLE_PASTEVENT_SIDEBAR];
                break;
        }

        return $ret;
    }

    public function getScreen(\PoP\ComponentModel\Component\Component $component)
    {
        $screens = array(
            self::COMPONENT_MULTIPLE_SINGLE_EVENT_RECOMMENDEDBYSIDEBAR => POP_SCREEN_SINGLEUSERS,
            self::COMPONENT_MULTIPLE_SINGLE_PASTEVENT_RECOMMENDEDBYSIDEBAR => POP_SCREEN_SINGLEUSERS,
        );
        if ($screen = $screens[$component->name] ?? null) {
            return $screen;
        }

        return parent::getScreen($component);
    }

    public function getScreengroup(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_MULTIPLE_SINGLE_EVENT_RECOMMENDEDBYSIDEBAR:
            case self::COMPONENT_MULTIPLE_SINGLE_PASTEVENT_RECOMMENDEDBYSIDEBAR:
                return POP_SCREENGROUP_CONTENTREAD;
        }

        return parent::getScreengroup($component);
    }
}


