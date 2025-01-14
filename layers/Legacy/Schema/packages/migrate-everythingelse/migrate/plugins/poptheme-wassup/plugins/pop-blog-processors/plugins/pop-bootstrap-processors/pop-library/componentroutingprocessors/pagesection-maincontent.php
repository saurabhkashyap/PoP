<?php

use PoP\Root\Routing\RequestNature;
use PoPCMSSchema\Posts\ModuleConfiguration as PostsModuleConfiguration;
use PoPCMSSchema\Tags\Routing\RequestNature as TagRequestNature;
use PoPCMSSchema\Users\ModuleConfiguration as UsersModuleConfiguration;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;

class PoPTheme_Wassup_Blog_Bootstrap_Module_MainPageSectionComponentRoutingProcessor extends PoP_Module_MainPageSectionComponentRoutingProcessorBase
{
    /**
     * @return array<string,array<string,array<array<string,mixed>>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        // Page modules
        $routeComponents = array(
            POP_BLOG_ROUTE_CONTENT => [PoP_Module_Processor_TabPanelSectionBlocks::class, PoP_Module_Processor_TabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_CONTENT],
            PostsModuleConfiguration::getPostsRoute() => [PoP_Module_Processor_TabPanelSectionBlocks::class, PoP_Module_Processor_TabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_POSTS],
            POP_BLOG_ROUTE_SEARCHCONTENT => [PoP_Module_Processor_TabPanelSectionBlocks::class, PoP_Module_Processor_TabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_SEARCHCONTENT],
            UsersModuleConfiguration::getUsersRoute() => [PoP_Module_Processor_TabPanelSectionBlocks::class, PoP_Module_Processor_TabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_USERS],
            POP_BLOG_ROUTE_SEARCHUSERS => [PoP_Module_Processor_TabPanelSectionBlocks::class, PoP_Module_Processor_TabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_SEARCHUSERS],
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
            POP_BLOG_ROUTE_CONTENT => [PoP_Module_Processor_AuthorTabPanelSectionBlocks::class, PoP_Module_Processor_AuthorTabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_AUTHORCONTENT],
            PostsModuleConfiguration::getPostsRoute() => [PoP_Module_Processor_AuthorTabPanelSectionBlocks::class, PoP_Module_Processor_AuthorTabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_AUTHORPOSTS],
        );
        foreach ($routeComponents as $route => $component) {
            $ret[UserRequestNature::USER][$route][] = [
                'component' => $component,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        // Tag route modules
        $routeComponents = array(
            POP_BLOG_ROUTE_CONTENT => [PoP_Module_Processor_TagTabPanelSectionBlocks::class, PoP_Module_Processor_TagTabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_TAGCONTENT],
            PostsModuleConfiguration::getPostsRoute() => [PoP_Module_Processor_TagTabPanelSectionBlocks::class, PoP_Module_Processor_TagTabPanelSectionBlocks::COMPONENT_BLOCK_TABPANEL_TAGPOSTS],
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
		new PoPTheme_Wassup_Blog_Bootstrap_Module_MainPageSectionComponentRoutingProcessor()
	);
}, 200);
