<?php
use PoP\ComponentModel\ComponentProcessors\Constants;

\PoP\Root\App::addFilter(
	Constants::HOOK_QUERYDATA_WHITELISTEDPARAMS, 
	function($params) {
	    $params[] = GD_URLPARAM_TIMESTAMP;
	    return $params;
	}
);
