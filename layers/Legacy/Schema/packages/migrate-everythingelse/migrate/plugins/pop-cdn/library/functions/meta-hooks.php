<?php

class PoP_CDN_Meta_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            '\PoP\ComponentModel\Engine:site-meta',
            $this->getSiteMeta(...)
        );
    }

    public function getSiteMeta($meta)
    {
        global $pop_cdn_thumbprint_manager;

        // Add all the Thumbprint values
        $thumbprint_values = array();
        foreach ($pop_cdn_thumbprint_manager->getThumbprints() as $thumbprint) {
            $thumbprint_values[$thumbprint] = $pop_cdn_thumbprint_manager->getThumbprintValue($thumbprint);
        }
        $meta[POP_CDN_THUMBPRINTVALUES] = $thumbprint_values;

        return $meta;
    }
}

/**
 * Initialization
 */
new PoP_CDN_Meta_Hooks();
