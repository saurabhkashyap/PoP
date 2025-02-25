<?php
namespace PoP\Theme;

use PoP\Application\QueryInputOutputHandlers\ParamConstants;
use PoP\ComponentModel\Misc\RequestUtils;
use PoP\ComponentModel\State\ApplicationState;

class PoP_Theme_Meta_Hooks
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
        if (RequestUtils::fetchingSite()) {
            
            // Send the current selected theme back
            if (\PoP\Root\App::getState('theme')) {
                $meta[ParamConstants::PARAMS][GD_URLPARAM_THEME] = \PoP\Root\App::getState('theme');
            }
            if (\PoP\Root\App::getState('thememode')) {
                $meta[ParamConstants::PARAMS][GD_URLPARAM_THEMEMODE] = \PoP\Root\App::getState('thememode');
            }
            if (\PoP\Root\App::getState('themestyle')) {
                $meta[ParamConstants::PARAMS][GD_URLPARAM_THEMESTYLE] = \PoP\Root\App::getState('themestyle');
            }

            $pushurlprops = array();

            // Theme: send only when it's not the default one (so the user can still see/copy/share the embed/print URL)
            if (!\PoP\Root\App::getState('theme-isdefault')) {
                $pushurlprops[GD_URLPARAM_THEME] = \PoP\Root\App::getState('theme');
            }
            if (!\PoP\Root\App::getState('thememode-isdefault')) {
                $pushurlprops[GD_URLPARAM_THEMEMODE] = \PoP\Root\App::getState('thememode');
            }
            if (!\PoP\Root\App::getState('themestyle-isdefault')) {
                $pushurlprops[GD_URLPARAM_THEMESTYLE] = \PoP\Root\App::getState('themestyle');
            }

            if ($pushurlprops) {
                $meta[ParamConstants::PUSHURLATTS] = array_merge(
                    $meta[ParamConstants::PUSHURLATTS] ?? array(),
                    $pushurlprops
                );
            }
        }

        return $meta;
    }
}

/**
 * Initialization
 */
new PoP_Theme_Meta_Hooks();
