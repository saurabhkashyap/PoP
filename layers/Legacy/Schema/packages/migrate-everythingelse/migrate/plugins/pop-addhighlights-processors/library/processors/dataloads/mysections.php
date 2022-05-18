<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPSchema\Highlights\TypeResolvers\ObjectType\HighlightObjectTypeResolver;

class PoP_AddHighlights_Module_Processor_MySectionDataloads extends PoP_Module_Processor_MySectionDataloadsBase
{
    public final const MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT = 'dataload-myhighlights-table-edit';
    public final const MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW = 'dataload-myhighlights-scroll-fullviewpreview';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT],
            [self::class, self::MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW],
        );
    }

    public function getRelevantRoute(array $componentVariation, array &$props): ?string
    {
        return match($componentVariation[1]) {
            self::MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW => POP_ADDHIGHLIGHTS_ROUTE_MYHIGHLIGHTS,
            self::MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT => POP_ADDHIGHLIGHTS_ROUTE_MYHIGHLIGHTS,
            default => parent::getRelevantRoute($componentVariation, $props),
        };
    }

    public function getInnerSubmodule(array $componentVariation)
    {
        $inner_modules = array(
            self::MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT => [PoP_Module_Processor_Tables::class, PoP_Module_Processor_Tables::MODULE_TABLE_MYHIGHLIGHTS],
            self::MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::MODULE_SCROLL_HIGHLIGHTS_FULLVIEW],
        );

        return $inner_modules[$componentVariation[1]] ?? null;
    }

    public function getFilterSubmodule(array $componentVariation): ?array
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::MODULE_FILTER_MYHIGHLIGHTS];
        }

        return parent::getFilterSubmodule($componentVariation);
    }

    public function getFormat(array $componentVariation): ?string
    {

        // Add the format attr
        $tables = array(
            [self::class, self::MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT],
        );
        $fullviews = array(
            [self::class, self::MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW],
        );
        if (in_array($componentVariation, $tables)) {
            $format = POP_FORMAT_TABLE;
        } elseif (in_array($componentVariation, $fullviews)) {
            $format = POP_FORMAT_FULLVIEW;
        }

        return $format ?? parent::getFormat($componentVariation);
    }

    public function getRelationalTypeResolver(array $componentVariation): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW:
                return $this->instanceManager->getInstance(HighlightObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($componentVariation);
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_MYHIGHLIGHTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYHIGHLIGHTS_SCROLL_FULLVIEWPREVIEW:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::MODULE_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('highlights', 'poptheme-wassup'));
                $this->setProp([GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::class, GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::MODULE_LAYOUT_CHECKPOINTMESSAGE_LOGGEDIN], $props, 'action', TranslationAPIFacade::getInstance()->__('access your highlights', 'poptheme-wassup'));
                break;
        }
        parent::initModelProps($componentVariation, $props);
    }
}



