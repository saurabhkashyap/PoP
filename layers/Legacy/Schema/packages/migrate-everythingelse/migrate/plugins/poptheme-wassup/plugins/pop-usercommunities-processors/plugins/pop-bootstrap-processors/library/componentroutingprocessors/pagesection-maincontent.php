<?php

use PoP\Root\Routing\RequestNature;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;

class Wassup_URE_RoleProcessors_Bootstrap_Module_MainPageSectionComponentRoutingProcessor extends PoP_Module_MainPageSectionComponentRoutingProcessorBase
{
    /**
     * @return array<string,array<string,array<array<string,mixed>>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $routeComponents = array(
            POP_USERCOMMUNITIES_ROUTE_COMMUNITIES => [PoP_UserCommunities_ComponentProcessor_SectionBlocks::class, PoP_UserCommunities_ComponentProcessor_SectionBlocks::COMPONENT_BLOCK_TABPANEL_COMMUNITIES],
            POP_USERCOMMUNITIES_ROUTE_MYMEMBERS => [PoP_UserCommunities_ComponentProcessor_SectionBlocks::class, PoP_UserCommunities_ComponentProcessor_SectionBlocks::COMPONENT_BLOCK_TABPANEL_MYMEMBERS],
        );
        foreach ($routeComponents as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        // Author route modules
        $routeComponents = array(
            POP_USERCOMMUNITIES_ROUTE_MEMBERS => [PoP_UserCommunities_ComponentProcessor_AuthorSectionBlocks::class, PoP_UserCommunities_ComponentProcessor_AuthorSectionBlocks::COMPONENT_BLOCK_TABPANEL_AUTHORCOMMUNITYMEMBERS],
        );
        foreach ($routeComponents as $route => $component) {
            $ret[UserRequestNature::USER][$route][] = [
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
		new Wassup_URE_RoleProcessors_Bootstrap_Module_MainPageSectionComponentRoutingProcessor()
	);
}, 200);
