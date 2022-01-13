<?php
use PoP\Definitions\Facades\DefinitionManagerFacade;
use PoP\Routing\DefinitionGroups;
$definitionManager = DefinitionManagerFacade::getInstance();

// Routes
//--------------------------------------------------------
if (!defined('POP_ENGINEWEBPLATFORM_ROUTE_APPSHELL')) {
	define('POP_ENGINEWEBPLATFORM_ROUTE_APPSHELL', $definitionManager->getUniqueDefinition('loaders/appshell', DefinitionGroups::ROUTES));
}

\PoP\Root\App::getHookManager()->addFilter(
    \PoP\Routing\RouteHookNames::ROUTES,
    function($routes) {
    	return array_merge(
    		$routes,
    		[
    			POP_ENGINEWEBPLATFORM_ROUTE_APPSHELL,
    		]
    	);
    }
);
