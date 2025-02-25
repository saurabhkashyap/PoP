<?php

class PoP_RelatedPosts_Module_Processor_CustomSectionBlocks extends PoP_Module_Processor_SectionBlocksBase
{
    public final const COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_DETAILS = 'block-singlerelatedcontent-scroll-details';
    public final const COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW = 'block-singlerelatedcontent-scroll-simpleview';
    public final const COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_FULLVIEW = 'block-singlerelatedcontent-scroll-fullview';
    public final const COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL = 'block-singlerelatedcontent-scroll-thumbnail';
    public final const COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_LIST = 'block-singlerelatedcontent-scroll-list';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_DETAILS,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_FULLVIEW,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_LIST,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_DETAILS => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_FULLVIEW => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_LIST => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    protected function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inner_components = array(
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW => [PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::class, PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW],
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_FULLVIEW => [PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::class, PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_FULLVIEW],
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_DETAILS => [PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::class, PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_DETAILS],
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL => [PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::class, PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL],
            self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_LIST => [PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::class, PoP_RelatedPosts_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_SINGLERELATEDCONTENT_SCROLL_LIST],
        );

        return $inner_components[$component->name] ?? null;
    }

    protected function getSectionFilterComponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_DETAILS:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_LIST:
                if (defined('POP_TAXONOMYQUERY_INITIALIZED') && PoP_Application_TaxonomyQuery_ConfigurationUtils::enableFilterAllcontentByTaxonomy() && PoP_ApplicationProcessors_Utils::addSections()) {
                    return [PoP_Module_Processor_InstantaneousFilters::class, PoP_Module_Processor_InstantaneousFilters::COMPONENT_INSTANTANEOUSFILTER_CONTENTSECTIONS];
                }
                break;
        }

        return parent::getSectionFilterComponent($component);
    }

    protected function getControlgroupTopSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_DETAILS:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_THUMBNAIL:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_LIST:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::COMPONENT_CONTROLGROUP_BLOCKPOSTLIST];
        }

        return parent::getControlgroupTopSubcomponent($component);
    }

    public function getLatestcountSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_DETAILS:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_SIMPLEVIEW:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_FULLVIEW:
            case self::COMPONENT_BLOCK_SINGLERELATEDCONTENT_SCROLL_LIST:
                return [PoP_Module_Processor_LatestCounts::class, PoP_Module_Processor_LatestCounts::COMPONENT_LATESTCOUNT_SINGLE_CONTENT];
        }

        return parent::getLatestcountSubcomponent($component);
    }
}



