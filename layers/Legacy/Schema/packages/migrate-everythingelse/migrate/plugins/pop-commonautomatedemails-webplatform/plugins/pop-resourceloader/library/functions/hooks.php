<?php

class PoP_CommonAutomatedEmails_ResourceLoader_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'PoP_AutomatedEmails_WebPlatform_ResourceLoader_Utils:automatedemail-routes',
            $this->getAutomatedEmailRoutes(...)
        );
    }

    public function getAutomatedEmailRoutes($routes)
    {
        $routes[] = POP_COMMONAUTOMATEDEMAILS_ROUTE_LATESTCONTENT_WEEKLY;
        $routes[] = POP_COMMONAUTOMATEDEMAILS_ROUTE_SINGLEPOST_SPECIAL;
        return $routes;
    }
}

/**
 * Initialization
 */
new PoP_CommonAutomatedEmails_ResourceLoader_Hooks();
