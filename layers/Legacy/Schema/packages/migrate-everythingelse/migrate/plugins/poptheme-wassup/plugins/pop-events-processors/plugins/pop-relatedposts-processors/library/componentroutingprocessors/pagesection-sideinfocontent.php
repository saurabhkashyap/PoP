<?php

use PoPCMSSchema\CustomPosts\Routing\RequestNature as CustomPostRequestNature;
use PoPCMSSchema\Events\Facades\EventTypeAPIFacade;

class PoPTheme_Wassup_Events_RelatedPosts_Module_SideInfoContentPageSectionComponentRoutingProcessor extends PoP_Module_SideInfoContentPageSectionComponentRoutingProcessorBase
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $eventTypeAPI = EventTypeAPIFacade::getInstance();

        // Past single event
        $componentVariations = array(
            POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT => [PoP_Events_RelatedPosts_Module_Processor_SidebarMultiples::class, PoP_Events_RelatedPosts_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_PASTEVENT_RELATEDCONTENTSIDEBAR],
        );
        foreach ($componentVariations as $route => $componentVariation) {
            $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = [
                'component-variation' => $componentVariation,
                'conditions' => [
                    'routing' => [
                        'queried-object-post-type' => $eventTypeAPI->getEventCustomPostType(),
                        'queried-object-is-past-event' => true,
                    ],
                ],
            ];
        }

        // Future and current single event
        $componentVariations = array(
            POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT => [PoP_Events_RelatedPosts_Module_Processor_SidebarMultiples::class, PoP_Events_RelatedPosts_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_EVENT_RELATEDCONTENTSIDEBAR],
        );
        foreach ($componentVariations as $route => $componentVariation) {
            $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = [
                'component-variation' => $componentVariation,
                'conditions' => [
                    'routing' => [
                        'queried-object-post-type' => $eventTypeAPI->getEventCustomPostType(),
                    ],
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
		new PoPTheme_Wassup_Events_RelatedPosts_Module_SideInfoContentPageSectionComponentRoutingProcessor()
	);
}, 200);
