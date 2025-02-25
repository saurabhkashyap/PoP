<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\CustomPosts\Routing\RequestNature as CustomPostRequestNature;
use PoPSchema\Highlights\TypeResolvers\ObjectType\HighlightObjectTypeResolver;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;

class PoP_AddHighlights_Module_Processor_CustomSectionDataloads extends PoP_Module_Processor_SectionDataloadsBase
{
    public final const COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW = 'dataload-authorhighlights-scroll-fullview';
    public final const COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST = 'dataload-authorhighlights-scroll-list';
    public final const COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL = 'dataload-authorhighlights-scroll-thumbnail';
    public final const COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_ADDONS = 'dataload-highlights-scroll-addons';
    public final const COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW = 'dataload-highlights-scroll-fullview';
    public final const COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST = 'dataload-highlights-scroll-list';
    public final const COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_NAVIGATOR = 'dataload-highlights-scroll-navigator';
    public final const COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL = 'dataload-highlights-scroll-thumbnail';
    public final const COMPONENT_DATALOAD_HIGHLIGHTS_TYPEAHEAD = 'dataload-highlights-typeahead';
    public final const COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW = 'dataload-singlerelatedhighlightcontent-scroll-fullview';
    public final const COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL = 'dataload-singlerelatedhighlightcontent-scroll-thumbnail';
    public final const COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST = 'dataload-singlerelatedhighlightcontent-scroll-list';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_TYPEAHEAD,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_NAVIGATOR,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_ADDONS,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_ADDONS => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_NAVIGATOR => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_HIGHLIGHTS_TYPEAHEAD => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL => POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inner_components = array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_TYPEAHEAD => [PoP_Module_Processor_PostTypeaheadComponentLayouts::class, PoP_Module_Processor_PostTypeaheadComponentLayouts::COMPONENT_LAYOUTPOST_TYPEAHEAD_COMPONENT],
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_NAVIGATOR => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_NAVIGATOR],
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_ADDONS => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_ADDONS],
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_FULLVIEW],
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_THUMBNAIL],
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_LIST],
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_AUTHORHIGHLIGHTS_FULLVIEW],
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_THUMBNAIL],
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_LIST],
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_FULLVIEW],
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_THUMBNAIL],
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST => [PoP_Module_Processor_CustomScrolls::class, PoP_Module_Processor_CustomScrolls::COMPONENT_SCROLL_HIGHLIGHTS_LIST],
        );

        return $inner_components[$component->name] ?? null;
    }

    public function getFilterSubcomponent(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\Component\Component
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_TYPEAHEAD:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::COMPONENT_FILTER_HIGHLIGHTS];

            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST:
                return [PoP_AddHighlights_Module_Processor_CustomFilters::class, PoP_AddHighlights_Module_Processor_CustomFilters::COMPONENT_FILTER_AUTHORHIGHLIGHTS];
        }

        return parent::getFilterSubcomponent($component);
    }

    public function getFormat(\PoP\ComponentModel\Component\Component $component): ?string
    {

        // Add the format attr
        $navigators = array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_NAVIGATOR,
        );
        $addons = array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_ADDONS,
        );
        $fullviews = array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW,
        );
        $thumbnails = array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL,
        );
        $lists = array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST,
            self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST,
            self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST,
        );
        $typeaheads = array(
            self::COMPONENT_DATALOAD_HIGHLIGHTS_TYPEAHEAD,
        );
        if (in_array($component, $navigators)) {
            $format = POP_FORMAT_NAVIGATOR;
        } elseif (in_array($component, $addons)) {
            $format = POP_FORMAT_ADDONS;
        } elseif (in_array($component, $fullviews)) {
            $format = POP_FORMAT_FULLVIEW;
        } elseif (in_array($component, $thumbnails)) {
            $format = POP_FORMAT_THUMBNAIL;
        } elseif (in_array($component, $lists)) {
            $format = POP_FORMAT_LIST;
        } elseif (in_array($component, $typeaheads)) {
            $format = POP_FORMAT_TYPEAHEAD;
        }

        return $format ?? parent::getFormat($component);
    }

    // public function getNature(\PoP\ComponentModel\Component\Component $component)
    // {
    //     switch ($component->name) {
    //         case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW:
    //         case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL:
    //         case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST:
    //             return UserRequestNature::USER;

    //         case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW:
    //         case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL:
    //         case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST:
    //             return CustomPostRequestNature::CUSTOMPOST;
    //     }

    //     return parent::getNature($component);
    // }

    protected function getMutableonrequestDataloadQueryArgs(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getMutableonrequestDataloadQueryArgs($component, $props);

        switch ($component->name) {
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST:
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsAuthorcontent($ret);
                break;

            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST:
                PoP_AddHighlights_Module_Processor_SectionBlocksUtils::addDataloadqueryargsSinglehighlights($ret);
                break;
        }

        return $ret;
    }

    public function getRelationalTypeResolver(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_TYPEAHEAD:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_NAVIGATOR:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_ADDONS:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST:
                return $this->instanceManager->getInstance(HighlightObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($component);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_NAVIGATOR:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_ADDONS:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_AUTHORHIGHLIGHTS_SCROLL_LIST:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_DATALOAD_SINGLERELATEDHIGHLIGHTCONTENT_SCROLL_LIST:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('highlights', 'poptheme-wassup'));
                break;
        }

        parent::initModelProps($component, $props);
    }
}



