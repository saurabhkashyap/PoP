<?php

// High priority: allow the Theme and other plug-ins to set the values in advance.
\PoP\Root\App::addAction(
    'init', // Must migrate this WP hook to one from PoP (which executes before AFTER_BOOT_APPLICATION
    'popNotificationsprocessorsInitConstants', 
    10000
);
function popNotificationsprocessorsInitConstants()
{
    include_once 'constants.php';
}
