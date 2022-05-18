<?php

use PoPCMSSchema\CustomPosts\Routing\RequestNature as CustomPostRequestNature;

class PoPTheme_Wassup_LocationPosts_RelatedPosts_Module_SideInfoContentPageSectionComponentRoutingProcessor extends PoP_Module_SideInfoContentPageSectionComponentRoutingProcessorBase
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $componentVariations = array(
            POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT => [PoP_LocationPosts_RelatedContent_Module_Processor_SidebarMultiples::class, PoP_LocationPosts_RelatedContent_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_LOCATIONPOST_RELATEDCONTENTSIDEBAR],
        );
        foreach ($componentVariations as $route => $componentVariation) {
            $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = [
                'component-variation' => $componentVariation,
                'conditions' => [
                    'routing' => [
                        'queried-object-post-type' => POP_LOCATIONPOSTS_POSTTYPE_LOCATIONPOST,
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
		new PoPTheme_Wassup_LocationPosts_RelatedPosts_Module_SideInfoContentPageSectionComponentRoutingProcessor()
	);
}, 200);
