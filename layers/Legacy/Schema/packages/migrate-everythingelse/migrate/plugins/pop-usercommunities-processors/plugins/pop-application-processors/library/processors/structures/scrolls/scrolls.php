<?php

class PoP_UserCommunities_Module_Processor_CustomScrolls extends PoP_Module_Processor_ScrollsBase
{
    public final const COMPONENT_SCROLL_MYMEMBERS_FULLVIEWPREVIEW = 'scroll-mymembers-fullviewpreview';
    public final const COMPONENT_SCROLL_COMMUNITIES_DETAILS = 'scroll-communities-details';
    public final const COMPONENT_SCROLL_COMMUNITIES_FULLVIEW = 'scroll-communities-fullview';
    public final const COMPONENT_SCROLL_COMMUNITIES_THUMBNAIL = 'scroll-communities-thumbnail';
    public final const COMPONENT_SCROLL_COMMUNITIES_LIST = 'scroll-communities-list';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_SCROLL_MYMEMBERS_FULLVIEWPREVIEW,
            self::COMPONENT_SCROLL_COMMUNITIES_DETAILS,
            self::COMPONENT_SCROLL_COMMUNITIES_FULLVIEW,
            self::COMPONENT_SCROLL_COMMUNITIES_THUMBNAIL,
            self::COMPONENT_SCROLL_COMMUNITIES_LIST,
        );
    }


    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inners = array(
            self::COMPONENT_SCROLL_MYMEMBERS_FULLVIEWPREVIEW => [PoP_UserCommunities_Module_Processor_CustomScrollInners::class, PoP_UserCommunities_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_MYMEMBERS_FULLVIEWPREVIEW],
            self::COMPONENT_SCROLL_COMMUNITIES_DETAILS => [PoP_UserCommunities_Module_Processor_CustomScrollInners::class, PoP_UserCommunities_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_COMMUNITIES_DETAILS],
            self::COMPONENT_SCROLL_COMMUNITIES_FULLVIEW => [PoP_UserCommunities_Module_Processor_CustomScrollInners::class, PoP_UserCommunities_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_COMMUNITIES_FULLVIEW],
            self::COMPONENT_SCROLL_COMMUNITIES_THUMBNAIL => [PoP_UserCommunities_Module_Processor_CustomScrollInners::class, PoP_UserCommunities_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_COMMUNITIES_THUMBNAIL],
            self::COMPONENT_SCROLL_COMMUNITIES_LIST => [PoP_UserCommunities_Module_Processor_CustomScrollInners::class, PoP_UserCommunities_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_COMMUNITIES_LIST],
        );

        if ($inner = $inners[$component->name] ?? null) {
            return $inner;
        }

        return parent::getInnerSubcomponent($component);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {

        // Extra classes
        $thumbnails = array(
            self::COMPONENT_SCROLL_COMMUNITIES_THUMBNAIL,
        );
        $lists = array(
            self::COMPONENT_SCROLL_COMMUNITIES_LIST,
        );
        $details = array(
            self::COMPONENT_SCROLL_COMMUNITIES_DETAILS,
        );
        $fullviews = array(
            self::COMPONENT_SCROLL_MYMEMBERS_FULLVIEWPREVIEW,
            self::COMPONENT_SCROLL_COMMUNITIES_FULLVIEW,
        );

        $extra_class = '';
        if (in_array($component, $fullviews)) {
            $extra_class = 'fullview';
        } elseif (in_array($component, $details)) {
            $extra_class = 'details';
        } elseif (in_array($component, $thumbnails)) {
            $extra_class = 'thumb';
        } elseif (in_array($component, $lists)) {
            $extra_class = 'list';
        }
        $this->appendProp($component, $props, 'class', $extra_class);

        parent::initModelProps($component, $props);
    }
}


