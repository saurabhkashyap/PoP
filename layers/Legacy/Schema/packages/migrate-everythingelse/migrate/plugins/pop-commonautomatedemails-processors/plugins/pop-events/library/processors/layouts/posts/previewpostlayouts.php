<?php

class PoPTheme_Wassup_EM_AE_Module_Processor_PreviewPostLayouts extends PoP_Module_Processor_CustomPreviewPostLayoutsBase
{
    public final const COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS = 'layout-automatedemails-previewpost-event-details';
    public final const COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL = 'layout-automatedemails-previewpost-event-thumbnail';
    public final const COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST = 'layout-automatedemails-previewpost-event-list';
    
    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS,
            self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL,
            self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST,
        );
    }


    public function getAuthorComponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:

                return [PoP_Module_Processor_PostAuthorNameLayouts::class, PoP_Module_Processor_PostAuthorNameLayouts::COMPONENT_LAYOUTPOST_AUTHORNAME];
        }

        return parent::getAuthorComponent($component);
    }

    public function getQuicklinkgroupBottomSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL:
                return [PoPTheme_Wassup_EM_AE_Module_Processor_QuicklinkGroups::class, PoPTheme_Wassup_EM_AE_Module_Processor_QuicklinkGroups::COMPONENT_QUICKLINKGROUP_EVENTBOTTOM];
        }

        return parent::getQuicklinkgroupBottomSubcomponent($component);
    }

    public function getBelowthumbLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getBelowthumbLayoutSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL:
                $ret[] = [GD_EM_Module_Processor_DateTimeLayouts::class, GD_EM_Module_Processor_DateTimeLayouts::COMPONENT_EM_LAYOUT_DATETIME];
                $ret[] = [PoP_Module_Processor_LocationViewComponentButtonWrapperss::class, PoP_Module_Processor_LocationViewComponentButtonWrapperss::COMPONENT_VIEWCOMPONENT_BUTTONWRAPPER_POSTLOCATIONS];
                break;

            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
                $ret[] = [GD_EM_Module_Processor_DateTimeLayouts::class, GD_EM_Module_Processor_DateTimeLayouts::COMPONENT_EM_LAYOUT_DATETIME];
                $ret[] = [PoP_Module_Processor_LocationViewComponentButtonWrapperss::class, PoP_Module_Processor_LocationViewComponentButtonWrapperss::COMPONENT_VIEWCOMPONENT_BUTTONWRAPPER_POSTLOCATIONS];
                break;
        }

        return $ret;
    }

    public function getBottomSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getBottomSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:
                $ret[] = [PoPTheme_Wassup_EM_AE_Module_Processor_QuicklinkGroups::class, PoPTheme_Wassup_EM_AE_Module_Processor_QuicklinkGroups::COMPONENT_QUICKLINKGROUP_EVENTBOTTOM];
                break;
        }

        return $ret;
    }

    public function getAbovecontentSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getAbovecontentSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:
                $ret[] = [GD_EM_Module_Processor_DateTimeLayouts::class, GD_EM_Module_Processor_DateTimeLayouts::COMPONENT_EM_LAYOUT_DATETIMEHORIZONTAL];
                $ret[] = [PoP_Module_Processor_LocationViewComponentButtonWrapperss::class, PoP_Module_Processor_LocationViewComponentButtonWrapperss::COMPONENT_VIEWCOMPONENT_BUTTONWRAPPER_POSTLOCATIONS];
                break;
        }

        return $ret;
    }

    public function getPostThumbSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:
                return [GD_Custom_Module_Processor_PostThumbLayouts::class, GD_Custom_Module_Processor_PostThumbLayouts::COMPONENT_LAYOUT_POSTTHUMB_CROPPEDSMALL_VOLUNTEER];

            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL:
                return [GD_Custom_Module_Processor_PostThumbLayouts::class, GD_Custom_Module_Processor_PostThumbLayouts::COMPONENT_LAYOUT_POSTTHUMB_CROPPEDMEDIUM_VOLUNTEER];
        }

        return parent::getPostThumbSubcomponent($component);
    }

    public function showExcerpt(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:

                return true;
        }

        return parent::showExcerpt($component);
    }

    public function getTitleHtmlmarkup(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
            
                return 'h3';
        }

        return parent::getTitleHtmlmarkup($component, $props);
    }

    public function authorPositions(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:

                return array(
                    GD_CONSTANT_AUTHORPOSITION_ABOVETITLE,
                );
        }

        return parent::authorPositions($component);
    }

    public function horizontalLayout(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
                
                return true;
        }

        return parent::horizontalLayout($component);
    }

    public function horizontalMediaLayout(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:

                return true;
        }

        return parent::horizontalMediaLayout($component);
    }
    

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_LIST:
                $ret[GD_JS_CLASSES]['excerpt'] = 'email-excerpt';
                $ret[GD_JS_CLASSES]['authors-abovetitle'] = 'email-authors-abovetitle';
                break;

            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_THUMBNAIL:
            
                $ret[GD_JS_CLASSES]['belowthumb'] = 'bg-info text-info belowthumb';
                break;
        }

        switch ($component->name) {
            case self::COMPONENT_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_DETAILS:
            
                $ret[GD_JS_CLASSES]['thumb'] = 'pop-thumb-framed';
                break;
        }

        return $ret;
    }
}


