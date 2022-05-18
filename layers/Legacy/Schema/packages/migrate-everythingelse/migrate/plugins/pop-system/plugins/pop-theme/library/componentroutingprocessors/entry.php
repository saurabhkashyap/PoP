<?php

use PoP\Root\Routing\RequestNature;

class PoPSystem_Theme_Module_EntryComponentRoutingProcessor extends \PoP\ComponentRouting\AbstractEntryComponentRoutingProcessor
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $routemodules = array(
            POP_SYSTEM_ROUTE_SYSTEM_GENERATETHEME => [PoP_System_Theme_Module_Processor_SystemActions::class, PoP_System_Theme_Module_Processor_SystemActions::MODULE_DATALOADACTION_SYSTEM_GENERATETHEME],
        );
        foreach ($routemodules as $route => $componentVariation) {
            $ret[RequestNature::GENERIC][$route][] = ['component-variation' => $componentVariation];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
    new PoPSystem_Theme_Module_EntryComponentRoutingProcessor()
	);
}, 200);
