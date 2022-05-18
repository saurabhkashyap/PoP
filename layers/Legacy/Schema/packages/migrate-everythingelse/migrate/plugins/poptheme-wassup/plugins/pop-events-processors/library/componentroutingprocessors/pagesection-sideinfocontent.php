<?php

use PoP\Root\Routing\RequestNature;
use PoPCMSSchema\CustomPosts\Routing\RequestNature as CustomPostRequestNature;
use PoPCMSSchema\Events\Facades\EventTypeAPIFacade;
use PoPCMSSchema\Tags\Routing\RequestNature as TagRequestNature;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;

class PoPTheme_Wassup_Events_Module_SideInfoContentPageSectionComponentRoutingProcessor extends PoP_Module_SideInfoContentPageSectionComponentRoutingProcessorBase
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $componentVariations = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOREVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORPASTEVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOREVENTSCALENDAR_SIDEBAR],
        );
        foreach ($componentVariations as $route => $componentVariation) {
            $ret[UserRequestNature::USER][$route][] = ['component-variation' => $componentVariation];
        }

        $componentVariations = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_EVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_PASTEVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_EVENTS_CALENDAR_SIDEBAR],
        );
        foreach ($componentVariations as $route => $componentVariation) {
            $ret[TagRequestNature::TAG][$route][] = ['component-variation' => $componentVariation];
        }

        $componentVariations = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_EVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_PASTEVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_EVENTS_CALENDAR_SIDEBAR],
        );
        foreach ($componentVariations as $route => $componentVariation) {
            $ret[RequestNature::GENERIC][$route][] = ['component-variation' => $componentVariation];
        }

        return $ret;
    }

    /**
     * @return array<string, array<array>>
     */
    public function getStatePropertiesToSelectComponentByNature(): array
    {
        $ret = array();

        $eventTypeAPI = EventTypeAPIFacade::getInstance();

        // Past single event
        $ret[CustomPostRequestNature::CUSTOMPOST][] = [
            'component-variation' => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_PASTEVENT_SIDEBAR],
            'conditions' => [
                'routing' => [
                    'queried-object-post-type' => $eventTypeAPI->getEventCustomPostType(),
                    'queried-object-is-past-event' => true,
                ],
            ],
        ];

        // Future and current single event
        $ret[CustomPostRequestNature::CUSTOMPOST][] = [
            'component-variation' => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_EVENT_SIDEBAR],
            'conditions' => [
                'routing' => [
                    'queried-object-post-type' => $eventTypeAPI->getEventCustomPostType(),
                ],
            ],
        ];

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
		new PoPTheme_Wassup_Events_Module_SideInfoContentPageSectionComponentRoutingProcessor()
	);
}, 200);
