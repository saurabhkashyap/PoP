<?php

class PoP_AddHighlights_Notifications_ImplementationHooks
{
    public function __construct()
    {
        \PoP\Root\App::addAction(
            'popcomponent:notifications:init',
            $this->addNotificationHooks(...)
        );
    }

    public function addNotificationHooks()
    {
        new PoP_AddHighlights_Notifications_Hook_Posts();
    }
}

/**
 * Initialize
 */
new PoP_AddHighlights_Notifications_ImplementationHooks();
