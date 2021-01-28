<?php
use PoP\ComponentModel\ModuleFiltering\ModuleFilterManager;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\Engine\DataStructureFormatters\DBItemListDataStructureFormatter;
use PoP\ComponentModel\State\ApplicationState;

class PoPCore_ModuleManager_Utils
{
    public static function addJsonoutputResultsParams($url, $format = null)
    {

        // Retrieve the dataload-source that will produce the data. Add the params to the URL
        $vars = ApplicationState::getVars();
        $args = [
            \PoP\ComponentModel\Constants\Params::VERSION => $vars['version'],
            GD_URLPARAM_OUTPUT => GD_URLPARAM_OUTPUT_JSON,
            ModuleFilterManager::URLPARAM_MODULEFILTER => \PoP\Engine\ModuleFilters\MainContentModule::NAME,
            GD_URLPARAM_DATAOUTPUTITEMS => [
                GD_URLPARAM_DATAOUTPUTITEMS_DATABASES,
            ],
            GD_URLPARAM_TARGET => POP_TARGET_MAIN,
            \PoP\ComponentModel\Constants\Params::DATASTRUCTURE => DBItemListDataStructureFormatter::getName(),
        ];
        if ($format) {
            $args[GD_URLPARAM_FORMAT] = $format;
        }
        return GeneralUtils::addQueryArgs($args, $url);
    }
}
