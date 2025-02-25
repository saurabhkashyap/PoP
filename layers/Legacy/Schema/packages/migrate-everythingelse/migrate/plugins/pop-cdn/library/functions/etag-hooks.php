<?php

class PoP_CDN_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            '\PoP\ComponentModel\Engine:etag_header:commoncode',
            $this->getCommoncode(...)
        );
    }

    public function getCommoncode($commoncode)
    {

        // Remove the thumbprint values from the ETag
        $commoncode = preg_replace('/"'.POP_CDN_THUMBPRINTVALUES.'":{.*?},?/', '', $commoncode);
        return $commoncode;
    }
}

/**
 * Initialization
 */
new PoP_CDN_Hooks();
