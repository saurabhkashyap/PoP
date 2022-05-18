<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

class UserStance_Module_Processor_CustomFullViewLayouts extends PoP_Module_Processor_CustomFullViewLayoutsBase
{
    public final const MODULE_LAYOUT_FULLVIEW_STANCE = 'layout-fullview-stance';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_FULLVIEW_STANCE],
        );
    }

    public function getFooterSubmodules(array $componentVariation)
    {
        $ret = parent::getFooterSubmodules($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_LAYOUT_FULLVIEW_STANCE:
                $ret[] = [PoP_Module_Processor_ViewComponentButtonWrappers::class, PoP_Module_Processor_ViewComponentButtonWrappers::MODULE_LAYOUTWRAPPER_SUBJUGATEDPOSTCONCLUSIONSIDEBAR_HORIZONTAL];
                $ret[] = [UserStance_Module_Processor_CustomWrapperLayouts::class, UserStance_Module_Processor_CustomWrapperLayouts::MODULE_LAYOUTWRAPPER_USERSTANCEPOSTINTERACTION];
                $ret[] = [PoP_Module_Processor_CustomWrapperLayouts::class, PoP_Module_Processor_CustomWrapperLayouts::MODULE_CODEWRAPPER_LAZYLOADINGSPINNER];
                $ret[] = [PoP_Module_Processor_PostCommentSubcomponentLayouts::class, PoP_Module_Processor_PostCommentSubcomponentLayouts::MODULE_LAZYSUBCOMPONENT_NOHEADERPOSTCOMMENTS];
                break;
        }

        return $ret;
    }

    public function getSidebarSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_LAYOUT_FULLVIEW_STANCE:
                $sidebars = array(
                    self::MODULE_LAYOUT_FULLVIEW_STANCE => [UserStance_Module_Processor_CustomPostLayoutSidebars::class, UserStance_Module_Processor_CustomPostLayoutSidebars::MODULE_LAYOUT_POSTSIDEBARCOMPACT_HORIZONTAL_STANCE],
                );

                return $sidebars[$componentVariation[1]];
        }

        return parent::getSidebarSubmodule($componentVariation);
    }

    public function getImmutableConfiguration(array $componentVariation, array &$props): array
    {
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        $ret = parent::getImmutableConfiguration($componentVariation, $props);

        switch ($componentVariation[1]) {
            case self::MODULE_LAYOUT_FULLVIEW_STANCE:
                $ret[GD_JS_CLASSES]['content'] = 'alert alert-stance';
                $ret[GD_JS_CLASSES]['content-inner'] = 'readable';
                break;
        }
        
        return $ret;
    }

    public function getAbovecontentSubmodules(array $componentVariation)
    {
        $ret = parent::getAbovecontentSubmodules($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_LAYOUT_FULLVIEW_STANCE:
                $ret[] = [UserStance_Module_Processor_Layouts::class, UserStance_Module_Processor_Layouts::MODULE_LAYOUTSTANCE];
                break;
        }

        return $ret;
    }
}



