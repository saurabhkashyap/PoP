<?php

use PoP\Root\Routing\RequestNature;

class PoPTheme_Wassup_CPLC_Module_MainContentComponentRoutingProcessor extends \PoP\Application\AbstractMainContentComponentRoutingProcessor
{
    /**
     * @return array<string,array<string,array<array<string,mixed>>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $default_format_mycontent = PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_MYCONTENT);

        $routeComponents = array(
            POP_CONTENTPOSTLINKSCREATION_ROUTE_ADDCONTENTPOSTLINK => [PoP_ContentPostLinksCreation_Module_Processor_CreateUpdatePostBlocks::class, PoP_ContentPostLinksCreation_Module_Processor_CreateUpdatePostBlocks::COMPONENT_BLOCK_CONTENTPOSTLINK_CREATE],
            POP_CONTENTPOSTLINKSCREATION_ROUTE_EDITCONTENTPOSTLINK => [PoP_ContentPostLinksCreation_Module_Processor_CreateUpdatePostBlocks::class, PoP_ContentPostLinksCreation_Module_Processor_CreateUpdatePostBlocks::COMPONENT_BLOCK_CONTENTPOSTLINK_UPDATE],
        );
        foreach ($routeComponents as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
        }

        $routeComponents_mycontent = array(
            POP_CONTENTPOSTLINKSCREATION_ROUTE_MYCONTENTPOSTLINKS => [PoP_ContentPostLinksCreation_Module_Processor_MySectionBlocks::class, PoP_ContentPostLinksCreation_Module_Processor_MySectionBlocks::COMPONENT_BLOCK_MYLINKS_TABLE_EDIT],
        );
        foreach ($routeComponents_mycontent as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_TABLE,
                ],
            ];
            if ($default_format_mycontent == POP_FORMAT_TABLE) {
                $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
            }
        }
        $routeComponents_mycontent_simpleviewpreviews = array(
            POP_CONTENTPOSTLINKSCREATION_ROUTE_MYCONTENTPOSTLINKS => [PoP_ContentPostLinksCreation_Module_Processor_MySectionBlocks::class, PoP_ContentPostLinksCreation_Module_Processor_MySectionBlocks::COMPONENT_BLOCK_MYLINKS_SCROLL_SIMPLEVIEWPREVIEW],
        );
        foreach ($routeComponents_mycontent_simpleviewpreviews as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_SIMPLEVIEW,
                ],
            ];
            if ($default_format_mycontent == POP_FORMAT_SIMPLEVIEW) {
                $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
            }
        }
        $routeComponents_mycontent_fullviewpreviews = array(
            POP_CONTENTPOSTLINKSCREATION_ROUTE_MYCONTENTPOSTLINKS => [PoP_ContentPostLinksCreation_Module_Processor_MySectionBlocks::class, PoP_ContentPostLinksCreation_Module_Processor_MySectionBlocks::COMPONENT_BLOCK_MYLINKS_SCROLL_FULLVIEWPREVIEW],
        );
        foreach ($routeComponents_mycontent_fullviewpreviews as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_FULLVIEW,
                ],
            ];
            if ($default_format_mycontent == POP_FORMAT_FULLVIEW) {
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
		new PoPTheme_Wassup_CPLC_Module_MainContentComponentRoutingProcessor()
	);
}, 200);
