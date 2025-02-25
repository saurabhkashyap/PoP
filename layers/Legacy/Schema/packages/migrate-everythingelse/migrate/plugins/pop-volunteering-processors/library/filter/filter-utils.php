<?php

class PoP_VolunteeringProcessors_FilterUtils
{
    private static $volunteer_components;

    public static function getVolunteerComponents()
    {
        if (is_null(self::$volunteer_components)) {
            $volunteer_components = \PoP\Root\App::applyFilters(
                'PoP_VolunteeringProcessors_FilterUtils:volunteer-modules',
                array()
            );
            self::$volunteer_components = [];
            foreach ($volunteer_components as $volunteer_component) {
                $component = $volunteer_component['component'];
                $componentFullName = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentFullName($component);
                self::$volunteer_components[$componentFullName] = $volunteer_component['volunteerModule'];
            }
        }

        return self::$volunteer_components;
    }

    public static function maybeAddVolunteerFilterinput($filterinputs, \PoP\ComponentModel\Component\Component $component)
    {
        if (defined('POP_VOLUNTEERING_ROUTE_VOLUNTEER') && POP_VOLUNTEERING_ROUTE_VOLUNTEER) {
            $volunteer_components = self::getVolunteerComponents();
            $componentFullName = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentFullName($component);
            if ($volunteer_component = $volunteer_components[$componentFullName] ?? null) {
                $filterinputs[] = $volunteer_component;
            }
        }

        return $filterinputs;
    }
}
