<?php

use PoP\Root\Routing\RequestNature;

class PoPTheme_Wassup_NoSearchCategoryPostsCreation_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getModulesVarsPropertiesByNatureAndRoute(): array
    {
        $ret = array();

        $routes = array(
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS00,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS01,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS02,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS03,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS04,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS05,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS06,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS07,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS08,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS09,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS10,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS11,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS12,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS13,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS14,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS15,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS16,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS17,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS18,
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS19,
        );
        foreach ($routes as $route) {
            $ret[RequestNature::GENERIC][$route][] = [
                'module' => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_MYCATEGORYPOSTS_SIDEBAR]
            ];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->addRouteModuleProcessor(
		new PoPTheme_Wassup_NoSearchCategoryPostsCreation_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
