<?php
use PoP\ComponentModel\State\ApplicationState;

\PoP\Root\App::addFilter('\PoP\ComponentModel\Engine:getExtraUris', 'popthemeWassupExtraRoutes');
function popthemeWassupExtraRoutes($extra_routes)
{
    if (!PoPTheme_Wassup_ServerUtils::disablePreloadingPages()) {
        // Load extra URIs for the INITIALFRAMES page
        if (\PoP\Root\App::getState(['routing', 'is-generic']) && \PoP\Root\App::getState('route') == POPTHEME_WASSUP_ROUTE_LOADERS_INITIALFRAMES) {
            $target = \PoP\Root\App::getState('target');
            if ($routes = \PoP\Root\App::applyFilters(
                'wassup:extra-routes:initialframes:'.$target,
                array()
            )) {
                $extra_routes = array_unique(
                    array_merge(
                        $extra_routes,
                        // array_map(array(RequestUtils::class, 'getPageUri'), $routes)
                        $routes
                    )
                );
            }
        }
    }

    return $extra_routes;
}
