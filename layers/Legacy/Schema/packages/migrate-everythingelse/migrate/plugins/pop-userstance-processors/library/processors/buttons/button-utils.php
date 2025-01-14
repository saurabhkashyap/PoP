<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class UserStance_Module_Processor_ButtonUtils
{
    public static function getSinglepostAddstanceTitle()
    {
        $post_id = \PoP\Root\App::getState(['routing', 'queried-object-id']);
    
        // Allow Events to have a different title
        return \PoP\Root\App::applyFilters(
            'UserStance_Module_Processor_ButtonUtils:singlepost:title',
            TranslationAPIFacade::getInstance()->__('After reading this information', 'pop-userstance-processors'),
            $post_id
        );
    }

    public static function getFullviewAddstanceTitle()
    {

        // Allow Events to have a different title
        return \PoP\Root\App::applyFilters(
            'UserStance_Module_Processor_ButtonUtils:fullview:title',
            TranslationAPIFacade::getInstance()->__('After reading this information', 'pop-userstance-processors')
        );
    }
}
