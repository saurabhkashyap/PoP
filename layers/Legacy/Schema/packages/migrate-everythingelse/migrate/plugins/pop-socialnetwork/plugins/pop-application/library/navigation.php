<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

/**
 * navigation.php
 */
\PoP\Root\App::addFilter('route:icon', 'popSocialnetworkRouteIcon', 10, 3);
function popSocialnetworkRouteIcon($icon, $route, $html = true)
{
    switch ($route) {
        case POP_SOCIALNETWORK_ROUTE_CONTACTUSER:
            $fontawesome = 'fa-envelope-o';
            break;
    }

    return processIcon($icon, $fontawesome, $html);
}

\PoP\Root\App::addFilter('route:title', 'popSocialnetworkNavigationRouteTitle', 10, 2);
function popSocialnetworkNavigationRouteTitle($title, $route)
{
    $titles = [
        POP_SOCIALNETWORK_ROUTE_CONTACTUSER => TranslationAPIFacade::getInstance()->__('Contact User', 'pop-socialnetwork'),
    ];
    return $titles[$route] ?? $title;
}
