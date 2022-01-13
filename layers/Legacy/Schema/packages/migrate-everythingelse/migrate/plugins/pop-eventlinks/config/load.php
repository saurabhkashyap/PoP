<?php

// High priority: allow the Theme and other plug-ins to set the values in advance.
\PoP\Root\App::getHookManager()->addAction(
    'popcms:init', 
    'popEventlinksInitConstants', 
    10000
);
function popEventlinksInitConstants()
{
    include_once 'constants.php';
}
