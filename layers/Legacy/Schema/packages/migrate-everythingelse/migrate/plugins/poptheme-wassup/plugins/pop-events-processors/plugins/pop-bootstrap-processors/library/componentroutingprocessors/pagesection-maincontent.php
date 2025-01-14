<?php

use PoP\Root\Routing\RequestNature;
use PoPCMSSchema\Tags\Routing\RequestNature as TagRequestNature;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;

class EMPoP_Bootstrap_Module_MainPageSectionComponentRoutingProcessor extends PoP_Module_MainPageSectionComponentRoutingProcessorBase
{
    /**
     * @return array<string,array<string,array<array<string,mixed>>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $routeComponents = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_SectionTabPanelBlocks::class, GD_EM_Module_Processor_SectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_EVENTS],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_SectionTabPanelBlocks::class, GD_EM_Module_Processor_SectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_PASTEVENTS],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_SectionTabPanelBlocks::class, GD_EM_Module_Processor_SectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_EVENTSCALENDAR],
        );
        foreach ($routeComponents as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        $routeComponents = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_AuthorSectionTabPanelBlocks::class, GD_EM_Module_Processor_AuthorSectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_AUTHOREVENTS],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_AuthorSectionTabPanelBlocks::class, GD_EM_Module_Processor_AuthorSectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_AUTHORPASTEVENTS],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_AuthorSectionTabPanelBlocks::class, GD_EM_Module_Processor_AuthorSectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_AUTHOREVENTSCALENDAR],
        );
        foreach ($routeComponents as $route => $component) {
            $ret[UserRequestNature::USER][$route][] = [
                'component' => $component,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        $routeComponents = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_TagSectionTabPanelBlocks::class, GD_EM_Module_Processor_TagSectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_TAGEVENTS],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_TagSectionTabPanelBlocks::class, GD_EM_Module_Processor_TagSectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_TAGPASTEVENTS],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_TagSectionTabPanelBlocks::class, GD_EM_Module_Processor_TagSectionTabPanelBlocks::COMPONENT_BLOCK_TABPANEL_TAGEVENTSCALENDAR],
        );
        foreach ($routeComponents as $route => $component) {
            $ret[TagRequestNature::TAG][$route][] = [
                'component' => $component,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
		new EMPoP_Bootstrap_Module_MainPageSectionComponentRoutingProcessor()
	);
}, 200);
