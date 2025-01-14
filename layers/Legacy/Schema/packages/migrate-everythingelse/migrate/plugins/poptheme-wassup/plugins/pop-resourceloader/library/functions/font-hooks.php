<?php

class PoPTheme_Wassup_ResourceLoader_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'getWassupFontUrl:pathkey',
            $this->getPathkey(...)
        );

        \PoP\Root\App::addFilter(
            'getFontawesomeFontUrl:pathkey',
            $this->getPathkey(...)
        );

        \PoP\Root\App::addFilter(
            'getWassupFontPath',
            $this->getFontPath(...),
            10,
            2
        );
        \PoP\Root\App::addFilter(
            'getFontawesomeFontPath',
            $this->getFontPath(...),
            10,
            2
        );
    }

    public function getPathkey($pathkey)
    {
        if (PoP_ResourceLoader_ServerUtils::useCodeSplitting() && PoP_ResourceLoader_ServerUtils::loadingBundlefile()) {
            return 'bundlefile';
        }
        
        return $pathkey;
    }

    public function getFontPath($font_path, $pathkey)
    {
        if ($pathkey == 'bundlefile') {
            $file = PoP_ResourceLoader_FileGenerator_BundleFiles_Utils::getFile(PoP_ResourceLoader_ServerUtils::getEnqueuefileType(true), POP_RESOURCELOADER_RESOURCETYPE_CSS, POP_RESOURCELOADER_RESOURCESUBTYPE_VENDOR);
            // dirname: Up 1 level from folder where the bundle(group) files were generated
            return dirname($file->getUrl());
        }
        
        return $font_path;
    }
}


/**
 * Initialization
 */
new PoPTheme_Wassup_ResourceLoader_Hooks();
