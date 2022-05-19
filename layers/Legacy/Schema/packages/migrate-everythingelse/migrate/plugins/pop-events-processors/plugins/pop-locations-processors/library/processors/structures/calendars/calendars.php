<?php

class PoP_Events_Locations_Module_Processor_Calendars extends PoP_Module_Processor_CalendarsBase
{
    public final const COMPONENT_CALENDAR_EVENTSMAP = 'calendar-eventsmap';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_CALENDAR_EVENTSMAP],
        );
    }

    public function getInnerSubcomponent(array $component)
    {
        $inners = array(
            self::COMPONENT_CALENDAR_EVENTSMAP => [PoP_Events_Locations_Module_Processor_CalendarInners::class, PoP_Events_Locations_Module_Processor_CalendarInners::COMPONENT_CALENDARINNER_EVENTSMAP],
        );

        if ($inner = $inners[$component[1]] ?? null) {
            return $inner;
        }

        return parent::getInnerSubcomponent($component);
    }

    public function getJsmethods(array $component, array &$props)
    {
        $ret = parent::getJsmethods($component, $props);

        switch ($component[1]) {
            case self::COMPONENT_CALENDAR_EVENTSMAP:
                $this->addJsmethod($ret, 'waypointsTheater');
                break;
        }

        return $ret;
    }

    public function initModelProps(array $component, array &$props): void
    {
        switch ($component[1]) {
            case self::COMPONENT_CALENDAR_EVENTSMAP:
                // Make the offcanvas theater when the scroll reaches top of the page
                $this->appendProp($component, $props, 'class', 'waypoint');
                $this->mergeProp(
                    $component,
                    $props,
                    'params',
                    array(
                        'data-toggle' => 'theater'
                    )
                );
                break;
        }

        switch ($component[1]) {
            case self::COMPONENT_CALENDAR_EVENTSMAP:
                // Make it activeItem: highlight on viewing the corresponding fullview
                $this->appendProp([GD_EM_Module_Processor_CustomPopoverLayouts::class, GD_EM_Module_Processor_CustomPopoverLayouts::COMPONENT_LAYOUT_POPOVER_EVENT], $props, 'class', 'pop-openmapmarkers');
                break;
        }

        parent::initModelProps($component, $props);
    }
}


