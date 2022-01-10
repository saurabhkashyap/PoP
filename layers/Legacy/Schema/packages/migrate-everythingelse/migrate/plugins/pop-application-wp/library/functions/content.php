<?php

use PoP\ComponentModel\State\ApplicationState;
use PoP\Engine\Route\RouteUtils;
use PoP\Hooks\Facades\HooksAPIFacade;

// If it is a route, then return its title as the Document Title
// Make sure it doesn't change the title for GraphQL persisted queries (/some-query/?view=source)
HooksAPIFacade::getInstance()->addFilter(
    'document_title_parts',
    function ($title) {
        if (\PoP\Root\App::getState(['routing', 'is-standard'])) {
            $title['title'] = strip_tags(RouteUtils::getRouteTitle(\PoP\Root\App::getState('route')));
        }
        return $title;
    }
);
