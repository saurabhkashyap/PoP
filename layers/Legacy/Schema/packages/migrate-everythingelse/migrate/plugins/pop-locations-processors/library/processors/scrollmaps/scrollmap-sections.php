<?php

class GD_EM_Module_Processor_CustomScrollMapSections extends GD_EM_Module_Processor_ScrollMapsBase
{
    public final const COMPONENT_SCROLLMAP_SEARCHUSERS_SCROLLMAP = 'scrollmap-searchusers-scrollmap';
    public final const COMPONENT_SCROLLMAP_USERS_SCROLLMAP = 'scrollmap-users-scrollmap';
    public final const COMPONENT_SCROLLMAP_USERS_HORIZONTALSCROLLMAP = 'scrollmap-users-horizontalscrollmap';
    public final const COMPONENT_SCROLLMAP_EVENTS_SCROLLMAP = 'scrollmap-events-scrollmap';
    public final const COMPONENT_SCROLLMAP_PASTEVENTS_SCROLLMAP = 'scrollmap-pastevents-scrollmap';
    public final const COMPONENT_SCROLLMAP_EVENTS_HORIZONTALSCROLLMAP = 'scrollmap-events-horizontalscrollmap';
    public final const COMPONENT_SCROLLMAP_AUTHOREVENTS_SCROLLMAP = 'scrollmap-authorevents-scrollmap';
    public final const COMPONENT_SCROLLMAP_AUTHORPASTEVENTS_SCROLLMAP = 'scrollmap-authorpastevents-scrollmap';
    public final const COMPONENT_SCROLLMAP_AUTHOREVENTS_HORIZONTALSCROLLMAP = 'scrollmap-authorevents-horizontalscrollmap';
    public final const COMPONENT_SCROLLMAP_TAGEVENTS_SCROLLMAP = 'scrollmap-tagevents-scrollmap';
    public final const COMPONENT_SCROLLMAP_TAGPASTEVENTS_SCROLLMAP = 'scrollmap-tagpastevents-scrollmap';
    public final const COMPONENT_SCROLLMAP_TAGEVENTS_HORIZONTALSCROLLMAP = 'scrollmap-tagevents-horizontalscrollmap';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_SCROLLMAP_EVENTS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_PASTEVENTS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_EVENTS_HORIZONTALSCROLLMAP,
            self::COMPONENT_SCROLLMAP_SEARCHUSERS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_USERS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_USERS_HORIZONTALSCROLLMAP,
            self::COMPONENT_SCROLLMAP_AUTHOREVENTS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_AUTHORPASTEVENTS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_AUTHOREVENTS_HORIZONTALSCROLLMAP,
            self::COMPONENT_SCROLLMAP_TAGEVENTS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_TAGPASTEVENTS_SCROLLMAP,
            self::COMPONENT_SCROLLMAP_TAGEVENTS_HORIZONTALSCROLLMAP,
        );
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inner_components = array(
            self::COMPONENT_SCROLLMAP_SEARCHUSERS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_USERS_MAP],
            self::COMPONENT_SCROLLMAP_USERS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_USERS_MAP],
            self::COMPONENT_SCROLLMAP_USERS_HORIZONTALSCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_USERS_HORIZONTALMAP],
            self::COMPONENT_SCROLLMAP_EVENTS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_EVENTS_MAP],
            self::COMPONENT_SCROLLMAP_PASTEVENTS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_PASTEVENTS_MAP],
            self::COMPONENT_SCROLLMAP_EVENTS_HORIZONTALSCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_EVENTS_HORIZONTALMAP],
            self::COMPONENT_SCROLLMAP_AUTHOREVENTS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_EVENTS_MAP],
            self::COMPONENT_SCROLLMAP_AUTHORPASTEVENTS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_PASTEVENTS_MAP],
            self::COMPONENT_SCROLLMAP_AUTHOREVENTS_HORIZONTALSCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_EVENTS_HORIZONTALMAP],
            self::COMPONENT_SCROLLMAP_TAGEVENTS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_EVENTS_MAP],
            self::COMPONENT_SCROLLMAP_TAGPASTEVENTS_SCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_PASTEVENTS_MAP],
            self::COMPONENT_SCROLLMAP_TAGEVENTS_HORIZONTALSCROLLMAP => [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_EVENTS_HORIZONTALMAP],
        );

        return $inner_components[$component->name] ?? null;
    }

    protected function isUserMap(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_SCROLLMAP_SEARCHUSERS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_USERS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_USERS_HORIZONTALSCROLLMAP:
                return true;
        }

        return parent::isUserMap($component);
    }

    protected function isPostMap(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_SCROLLMAP_EVENTS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_PASTEVENTS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_EVENTS_HORIZONTALSCROLLMAP:
            case self::COMPONENT_SCROLLMAP_AUTHOREVENTS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_AUTHORPASTEVENTS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_AUTHOREVENTS_HORIZONTALSCROLLMAP:
            case self::COMPONENT_SCROLLMAP_TAGEVENTS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_TAGPASTEVENTS_SCROLLMAP:
            case self::COMPONENT_SCROLLMAP_TAGEVENTS_HORIZONTALSCROLLMAP:
                return true;
        }

        return parent::isPostMap($component);
    }

    public function getMapDirection(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_SCROLLMAP_USERS_HORIZONTALSCROLLMAP:
            case self::COMPONENT_SCROLLMAP_EVENTS_HORIZONTALSCROLLMAP:
            case self::COMPONENT_SCROLLMAP_AUTHOREVENTS_HORIZONTALSCROLLMAP:
            case self::COMPONENT_SCROLLMAP_TAGEVENTS_HORIZONTALSCROLLMAP:
                return 'horizontal';
        }

        return parent::getMapDirection($component, $props);
    }
}



