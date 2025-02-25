<?php
use PoP\ComponentModel\State\ApplicationState;

class Wassup_EM_BP_SubmenuHooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'PoP_Module_Processor_CustomSubMenus:author:routes',
            $this->addRoutes(...)
        );
        \PoP\Root\App::addFilter(
            'PoP_Module_Processor_CustomSubMenus:tag:routes',
            $this->addRoutes(...)
        );
    }

    public function addRoutes($routes)
    {

        // Events
        if (defined('POP_EVENTS_ROUTE_EVENTS') && POP_EVENTS_ROUTE_EVENTS) {
            $event_subheaders = array(
                POP_EVENTS_ROUTE_EVENTSCALENDAR,
                POP_EVENTS_ROUTE_PASTEVENTS,
            );
            $routes[POP_EVENTS_ROUTE_EVENTS] = array_merge(
                array(
                    POP_EVENTS_ROUTE_EVENTS,
                ),
                $event_subheaders
            );
            $route = \PoP\Root\App::getState('route');
            if (in_array($route, $event_subheaders)) {
                $routes[$route] = array();
            }
        }
        
        return $routes;
    }
}

/**
 * Initialization
 */
new Wassup_EM_BP_SubmenuHooks();
