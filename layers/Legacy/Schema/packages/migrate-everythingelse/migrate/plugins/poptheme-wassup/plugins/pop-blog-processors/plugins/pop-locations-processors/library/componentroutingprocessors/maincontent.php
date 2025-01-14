<?php

use PoP\Root\Routing\RequestNature;
use PoPCMSSchema\Users\ModuleConfiguration as UsersModuleConfiguration;

class Wassup_EM_Blog_Module_MainContentComponentRoutingProcessor extends \PoP\Application\AbstractMainContentComponentRoutingProcessor
{
    /**
     * @return array<string,array<string,array<array<string,mixed>>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        // Page modules
        $routeComponents_map = array(
            UsersModuleConfiguration::getUsersRoute() => [GD_EM_Module_Processor_CustomScrollMapSectionBlocks::class, GD_EM_Module_Processor_CustomScrollMapSectionBlocks::COMPONENT_BLOCK_USERS_SCROLLMAP],
            POP_BLOG_ROUTE_SEARCHUSERS => [GD_EM_Module_Processor_CustomScrollMapSectionBlocks::class, GD_EM_Module_Processor_CustomScrollMapSectionBlocks::COMPONENT_BLOCK_SEARCHUSERS_SCROLLMAP],
        );
        foreach ($routeComponents_map as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_MAP,
                ],
            ];
            if ($default_format_section == POP_FORMAT_MAP) {
                $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
            }
        }

        $routeComponents_horizontalmap = array(
            UsersModuleConfiguration::getUsersRoute() => [GD_EM_Module_Processor_CustomScrollMapSectionBlocks::class, GD_EM_Module_Processor_CustomScrollMapSectionBlocks::COMPONENT_BLOCK_USERS_HORIZONTALSCROLLMAP],
        );
        foreach ($routeComponents_horizontalmap as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_HORIZONTALMAP,
                ],
            ];
            if ($default_format_section == POP_FORMAT_HORIZONTALMAP) {
                $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
            }
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
		new Wassup_EM_Blog_Module_MainContentComponentRoutingProcessor()
	);
}, 200);
