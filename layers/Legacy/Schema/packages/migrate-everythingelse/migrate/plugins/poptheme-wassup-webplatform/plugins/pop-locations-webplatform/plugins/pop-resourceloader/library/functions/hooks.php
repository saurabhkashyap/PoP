<?php

class PoPTheme_Wassup_EM_ResourceLoaderProcessor_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'PoP_WebPlatformQueryDataComponentProcessorBase:module-resources',
            $this->getModuleCssResources(...),
            10,
            6
        );
    }

    public function getModuleCssResources($resources, array $componentVariation, array $templateResource, $template, array $props, $processor)
    {
        switch ($template) {
            case POP_TEMPLATE_MAP_DIV:
                $resources[] = [PoPTheme_Wassup_EM_CSSResourceLoaderProcessor::class, PoPTheme_Wassup_EM_CSSResourceLoaderProcessor::RESOURCE_CSS_MAP];
                break;
        }

        // Artificial property added to identify the template when adding module-resources
        if ($resourceloader_att = $processor->getProp($componentVariation, $props, 'resourceloader')) {
            if ($resourceloader_att == 'map' || $resourceloader_att == 'calendarmap') {
                $resources[] = [PoPTheme_Wassup_EM_CSSResourceLoaderProcessor::class, PoPTheme_Wassup_EM_CSSResourceLoaderProcessor::RESOURCE_CSS_MAP];
            }
        }

        return $resources;
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_EM_ResourceLoaderProcessor_Hooks();
