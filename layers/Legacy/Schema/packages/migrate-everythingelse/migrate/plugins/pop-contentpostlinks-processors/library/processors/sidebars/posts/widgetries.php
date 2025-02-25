<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_ContentPostLinks_Module_Processor_CustomPostWidgets extends PoP_Module_Processor_WidgetsBase
{
    public final const COMPONENT_WIDGET_LINK_ACCESS = 'widget-link-access';
    public final const COMPONENT_WIDGET_LINK_CATEGORIES = 'widget-link-categories';
    public final const COMPONENT_WIDGETCOMPACT_LINKINFO = 'widgetcompact-link-info';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_WIDGET_LINK_ACCESS,
            self::COMPONENT_WIDGET_LINK_CATEGORIES,
            self::COMPONENT_WIDGETCOMPACT_LINKINFO,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getLayoutSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_WIDGET_LINK_ACCESS:
                $ret[] = [PoP_ContentPostLinks_Module_Processor_Layouts::class, PoP_ContentPostLinks_Module_Processor_Layouts::COMPONENT_LAYOUT_LINK_ACCESS];
                break;

            case self::COMPONENT_WIDGET_LINK_CATEGORIES:
                $ret[] = [PoP_ContentPostLinks_Module_Processor_WidgetWrappers::class, PoP_ContentPostLinks_Module_Processor_WidgetWrappers::COMPONENT_LAYOUTWRAPPER_LINK_CATEGORIES];
                break;

            case self::COMPONENT_WIDGETCOMPACT_LINKINFO:
                if (PoP_ApplicationProcessors_Utils::addCategories()) {
                    $ret[] = [Wassup_Module_Processor_WidgetWrappers::class, Wassup_Module_Processor_WidgetWrappers::COMPONENT_LAYOUTWRAPPER_CATEGORIES];
                }
                $ret[] = [PoP_ContentPostLinks_Module_Processor_Layouts::class, PoP_ContentPostLinks_Module_Processor_Layouts::COMPONENT_LAYOUT_LINK_ACCESS];
                $ret[] = [PoP_Module_Processor_PublishedLayouts::class, PoP_Module_Processor_PublishedLayouts::COMPONENT_LAYOUT_WIDGETPUBLISHED];
                break;
        }

        return $ret;
    }

    public function getMenuTitle(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $titles = array(
            self::COMPONENT_WIDGET_LINK_ACCESS => TranslationAPIFacade::getInstance()->__('Access type', 'poptheme-wassup'),
            self::COMPONENT_WIDGET_LINK_CATEGORIES => TranslationAPIFacade::getInstance()->__('Categories', 'poptheme-wassup'),
            self::COMPONENT_WIDGETCOMPACT_LINKINFO => TranslationAPIFacade::getInstance()->__('Link', 'poptheme-wassup'),
        );

        return $titles[$component->name] ?? null;
    }
    public function getFontawesome(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $fontawesomes = array(
            self::COMPONENT_WIDGET_LINK_ACCESS => 'fa-link',
            self::COMPONENT_WIDGET_LINK_CATEGORIES => 'fa-info-circle',
            self::COMPONENT_WIDGETCOMPACT_LINKINFO => 'fa-link',
        );

        return $fontawesomes[$component->name] ?? null;
    }

    public function getBodyClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_WIDGETCOMPACT_LINKINFO:
                return 'list-group list-group-sm';
        }

        return parent::getBodyClass($component, $props);
    }
    public function getItemWrapper(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_WIDGETCOMPACT_LINKINFO:
                return 'pop-hide-empty list-group-item';
        }

        return parent::getItemWrapper($component, $props);
    }
    public function getWidgetClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_WIDGETCOMPACT_LINKINFO:
                return 'panel panel-default panel-sm';
        }

        return parent::getWidgetClass($component, $props);
    }
}



