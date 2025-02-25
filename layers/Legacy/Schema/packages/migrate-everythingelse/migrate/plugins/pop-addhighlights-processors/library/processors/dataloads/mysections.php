<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPSchema\Highlights\TypeResolvers\ObjectType\HighlightObjectTypeResolver;

class PoP_AddHighlights_Module_Processor_MySectionDataloads extends PoP_Module_Processor_MySectionDataloadsBase
{
    public final const COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT = 'dataload-myhighlights-table-edit';
    public final const COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW = 'dataload-myhighlights-scroll-fullviewpreview';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT,
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW => POP_ADDHIGHLIGHTS_ROUTE_MYHIGHLIGHTS,
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT => POP_ADDHIGHLIGHTS_ROUTE_MYHIGHLIGHTS,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inner_components = array(
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT => [PoP_Module_Processor_Tables::class, PoP_Module_Processor_Tables::COMPONENT_TABLE_MYHIGHLIGHTS],
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_FULLVIEW],
        );

        return $inner_components[$component->name] ?? null;
    }

    public function getFilterSubcomponent(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\Component\Component
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT:
            case self::COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::COMPONENT_FILTER_MYHIGHLIGHTS];
        }

        return parent::getFilterSubcomponent($component);
    }

    public function getFormat(\PoP\ComponentModel\Component\Component $component): ?string
    {

        // Add the format attr
        $tables = array(
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT,
        );
        $fullviews = array(
            self::COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW,
        );
        if (in_array($component, $tables)) {
            $format = POP_FORMAT_TABLE;
        } elseif (in_array($component, $fullviews)) {
            $format = POP_FORMAT_FULLVIEW;
        }

        return $format ?? parent::getFormat($component);
    }

    public function getRelationalTypeResolver(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT:
            case self::COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW:
                return $this->instanceManager->getInstance(HighlightObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($component);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT:
            case self::COMPONENT_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('highlights', 'poptheme-wassup'));
                $this->setProp([GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::class, GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::COMPONENT_LAYOUT_CHECKPOINTMESSAGE_LOGGEDIN], $props, 'action', TranslationAPIFacade::getInstance()->__('access your highlights', 'poptheme-wassup'));
                break;
        }
        parent::initModelProps($component, $props);
    }
}



