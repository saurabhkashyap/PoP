<?php

class PoP_AddHighlights_SubmenuHooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'PoP_Module_Processor_CustomSubMenus:single:mainsubheaders',
            $this->addSingleMainsubheaders(...)
        );
    }

    public function addSingleMainsubheaders($routes)
    {
        return array_merge(
            $routes,
            array_filter(
                array(
                    POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
                )
            )
        );
    }
}

/**
 * Initialization
 */
new PoP_AddHighlights_SubmenuHooks();
