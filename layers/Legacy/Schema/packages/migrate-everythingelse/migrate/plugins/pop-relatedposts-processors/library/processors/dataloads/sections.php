<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\CustomPosts\TypeHelpers\CustomPostUnionTypeHelpers;

class PoP_RelatedPosts_Module_Processor_CustomSectionDataloads extends PoP_Module_Processor_SectionDataloadsBase
{
    public final const COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS = 'dataload-singlerelatedcontent-scroll-details';
    public final const COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW = 'dataload-singlerelatedcontent-scroll-simpleview';
    public final const COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW = 'dataload-singlerelatedcontent-scroll-fullview';
    public final const COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL = 'dataload-singlerelatedcontent-scroll-thumbnail';
    public final const COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST = 'dataload-singlerelatedcontent-scroll-list';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inner_components = array(
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_CONTENT_SIMPLEVIEW],
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_SINGLERELATEDCONTENT_FULLVIEW],
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_CONTENT_DETAILS],
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_CONTENT_THUMBNAIL],
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_CONTENT_LIST],
        );

        return $inner_components[$component->name] ?? null;
    }

    public function getFilterSubcomponent(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\Component\Component
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::COMPONENT_FILTER_CONTENT];
        }

        return parent::getFilterSubcomponent($component);
    }

    public function getFormat(\PoP\ComponentModel\Component\Component $component): ?string
    {

        // Add the format attr
        $details = array(
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS,
        );
        $simpleviews = array(
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW,
        );
        $fullviews = array(
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW,
        );
        $thumbnails = array(
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL,
        );
        $lists = array(
            self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST,
        );
        if (in_array($component, $details)) {
            $format = POP_FORMAT_DETAILS;
        } elseif (in_array($component, $fullviews)) {
            $format = POP_FORMAT_FULLVIEW;
        } elseif (in_array($component, $simpleviews)) {
            $format = POP_FORMAT_SIMPLEVIEW;
        } elseif (in_array($component, $thumbnails)) {
            $format = POP_FORMAT_THUMBNAIL;
        } elseif (in_array($component, $lists)) {
            $format = POP_FORMAT_LIST;
        }

        return $format ?? parent::getFormat($component);
    }

    // public function getNature(\PoP\ComponentModel\Component\Component $component)
    // {
    //     switch ($component->name) {
    //         case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS:
    //         case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
    //         case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
    //         case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL:
    //         case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST:
    //             return CustomPostRequestNature::CUSTOMPOST;
    //     }

    //     return parent::getNature($component);
    // }

    protected function getMutableonrequestDataloadQueryArgs(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getMutableonrequestDataloadQueryArgs($component, $props);

        switch ($component->name) {
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST:
                PoP_RelatedPosts_SectionUtils::addDataloadqueryargsReferences($ret);
                break;
        }

        return $ret;
    }

    public function getRelationalTypeResolver(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST:
                return CustomPostUnionTypeHelpers::getCustomPostUnionOrTargetObjectTypeResolver();
        }

        return parent::getRelationalTypeResolver($component);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('results', 'poptheme-wassup'));
                break;
        }

        parent::initModelProps($component, $props);
    }
}



