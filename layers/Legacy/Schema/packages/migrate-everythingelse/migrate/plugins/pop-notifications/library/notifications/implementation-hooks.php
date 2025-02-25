<?php

class PoP_Notifications_ImplementationHooks
{
    public function __construct()
    {

        // Add this library's hooks for AAL
        \PoP\Root\App::addAction(
            'popcomponent:notifications:init',
            $this->addNotificationHooks(...)
        );
    }

    public function addNotificationHooks()
    {
        new PoP_Notifications_Hook_Users();
    }
}

/**
 * Initialize
 */
new PoP_Notifications_ImplementationHooks();
