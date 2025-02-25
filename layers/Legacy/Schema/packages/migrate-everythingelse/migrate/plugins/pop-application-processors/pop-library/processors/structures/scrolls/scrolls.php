<?php

class PoP_Module_Processor_CustomScrolls extends PoP_Module_Processor_ScrollsBase
{
    public final const COMPONENT_SCROLL_CONTENT_NAVIGATOR = 'scroll-content-navigator';
    public final const COMPONENT_SCROLL_HIGHLIGHTS_NAVIGATOR = 'scroll-highlights-navigator';
    public final const COMPONENT_SCROLL_POSTS_NAVIGATOR = 'scroll-posts-navigator';
    public final const COMPONENT_SCROLL_USERS_NAVIGATOR = 'scroll-users-navigator';
    public final const COMPONENT_SCROLL_USER_NAVIGATOR = 'scroll-user-navigator';
    public final const COMPONENT_SCROLL_CONTENT_ADDONS = 'scroll-content-addons';
    public final const COMPONENT_SCROLL_HIGHLIGHTS_ADDONS = 'scroll-highlights-addons';
    public final const COMPONENT_SCROLL_POSTS_ADDONS = 'scroll-posts-addons';
    public final const COMPONENT_SCROLL_USERS_ADDONS = 'scroll-users-addons';
    public final const COMPONENT_SCROLL_USER_ADDONS = 'scroll-user-addons';
    public final const COMPONENT_SCROLL_CONTENT_DETAILS = 'scroll-content-details';
    public final const COMPONENT_SCROLL_POSTS_DETAILS = 'scroll-posts-details';
    public final const COMPONENT_SCROLL_TAGS_DETAILS = 'scroll-tags-details';
    public final const COMPONENT_SCROLL_USERS_DETAILS = 'scroll-users-details';
    public final const COMPONENT_SCROLL_USER_DETAILS = 'scroll-user-details';
    public final const COMPONENT_SCROLL_CONTENT_SIMPLEVIEW = 'scroll-content-simpleview';
    public final const COMPONENT_SCROLL_POSTS_SIMPLEVIEW = 'scroll-posts-simpleview';
    public final const COMPONENT_SCROLL_CONTENT_FULLVIEW = 'scroll-content-fullview';
    public final const COMPONENT_SCROLL_HIGHLIGHTS_FULLVIEW = 'scroll-highlights-fullview';
    public final const COMPONENT_SCROLL_POSTS_FULLVIEW = 'scroll-posts-fullview';
    public final const COMPONENT_SCROLL_USERS_FULLVIEW = 'scroll-users-fullview';
    public final const COMPONENT_SCROLL_USER_FULLVIEW = 'scroll-user-fullview';
    public final const COMPONENT_SCROLL_AUTHORCONTENT_FULLVIEW = 'scroll-authorcontent-fullview';
    public final const COMPONENT_SCROLL_AUTHORHIGHLIGHTS_FULLVIEW = 'scroll-authorhighlights-fullview';
    public final const COMPONENT_SCROLL_AUTHORPOSTS_FULLVIEW = 'scroll-authorposts-fullview';
    public final const COMPONENT_SCROLL_SINGLERELATEDCONTENT_FULLVIEW = 'scroll-singlerelatedcontent-fullview';
    public final const COMPONENT_SCROLL_CONTENT_THUMBNAIL = 'scroll-content-thumbnail';
    public final const COMPONENT_SCROLL_HIGHLIGHTS_THUMBNAIL = 'scroll-highlights-thumbnail';
    public final const COMPONENT_SCROLL_POSTS_THUMBNAIL = 'scroll-posts-thumbnail';
    public final const COMPONENT_SCROLL_USERS_THUMBNAIL = 'scroll-users-thumbnail';
    public final const COMPONENT_SCROLL_USER_THUMBNAIL = 'scroll-user-thumbnail';
    public final const COMPONENT_SCROLL_CONTENT_LIST = 'scroll-content-list';
    public final const COMPONENT_SCROLL_HIGHLIGHTS_LIST = 'scroll-highlights-list';
    public final const COMPONENT_SCROLL_POSTS_LIST = 'scroll-posts-list';
    public final const COMPONENT_SCROLL_TAGS_LIST = 'scroll-tags-list';
    public final const COMPONENT_SCROLL_POSTS_LINE = 'scroll-posts-line';
    public final const COMPONENT_SCROLL_USERS_LIST = 'scroll-users-list';
    public final const COMPONENT_SCROLL_USER_LIST = 'scroll-user-list';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_SCROLL_CONTENT_NAVIGATOR,
            self::COMPONENT_SCROLL_HIGHLIGHTS_NAVIGATOR,
            self::COMPONENT_SCROLL_POSTS_NAVIGATOR,
            self::COMPONENT_SCROLL_USERS_NAVIGATOR,
            self::COMPONENT_SCROLL_USER_NAVIGATOR,
            self::COMPONENT_SCROLL_CONTENT_ADDONS,
            self::COMPONENT_SCROLL_HIGHLIGHTS_ADDONS,
            self::COMPONENT_SCROLL_POSTS_ADDONS,
            self::COMPONENT_SCROLL_USERS_ADDONS,
            self::COMPONENT_SCROLL_USER_ADDONS,
            self::COMPONENT_SCROLL_CONTENT_DETAILS,
            self::COMPONENT_SCROLL_POSTS_DETAILS,
            self::COMPONENT_SCROLL_TAGS_DETAILS,
            self::COMPONENT_SCROLL_USERS_DETAILS,
            self::COMPONENT_SCROLL_USER_DETAILS,
            self::COMPONENT_SCROLL_CONTENT_SIMPLEVIEW,
            self::COMPONENT_SCROLL_POSTS_SIMPLEVIEW,
            self::COMPONENT_SCROLL_CONTENT_FULLVIEW,
            self::COMPONENT_SCROLL_HIGHLIGHTS_FULLVIEW,
            self::COMPONENT_SCROLL_POSTS_FULLVIEW,
            self::COMPONENT_SCROLL_USERS_FULLVIEW,
            self::COMPONENT_SCROLL_USER_FULLVIEW,
            self::COMPONENT_SCROLL_CONTENT_THUMBNAIL,
            self::COMPONENT_SCROLL_HIGHLIGHTS_THUMBNAIL,
            self::COMPONENT_SCROLL_POSTS_THUMBNAIL,
            self::COMPONENT_SCROLL_USERS_THUMBNAIL,
            self::COMPONENT_SCROLL_USER_THUMBNAIL,
            self::COMPONENT_SCROLL_CONTENT_LIST,
            self::COMPONENT_SCROLL_HIGHLIGHTS_LIST,
            self::COMPONENT_SCROLL_POSTS_LIST,
            self::COMPONENT_SCROLL_USERS_LIST,
            self::COMPONENT_SCROLL_USER_LIST,
            self::COMPONENT_SCROLL_TAGS_LIST,
            self::COMPONENT_SCROLL_POSTS_LINE,
            self::COMPONENT_SCROLL_AUTHORCONTENT_FULLVIEW,
            self::COMPONENT_SCROLL_AUTHORHIGHLIGHTS_FULLVIEW,
            self::COMPONENT_SCROLL_AUTHORPOSTS_FULLVIEW,
            self::COMPONENT_SCROLL_SINGLERELATEDCONTENT_FULLVIEW,
        );
    }


    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inners = array(
            self::COMPONENT_SCROLL_CONTENT_NAVIGATOR => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_CONTENT_NAVIGATOR],
            self::COMPONENT_SCROLL_HIGHLIGHTS_NAVIGATOR => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_HIGHLIGHTS_NAVIGATOR],
            self::COMPONENT_SCROLL_POSTS_NAVIGATOR => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_NAVIGATOR],
            self::COMPONENT_SCROLL_USERS_NAVIGATOR => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USERS_NAVIGATOR],
            self::COMPONENT_SCROLL_USER_NAVIGATOR => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USER_NAVIGATOR],
            self::COMPONENT_SCROLL_CONTENT_ADDONS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_CONTENT_ADDONS],
            self::COMPONENT_SCROLL_HIGHLIGHTS_ADDONS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_HIGHLIGHTS_ADDONS],
            self::COMPONENT_SCROLL_POSTS_ADDONS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_ADDONS],
            self::COMPONENT_SCROLL_USERS_ADDONS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USERS_ADDONS],
            self::COMPONENT_SCROLL_USER_ADDONS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USER_ADDONS],
            self::COMPONENT_SCROLL_CONTENT_DETAILS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_CONTENT_DETAILS],
            self::COMPONENT_SCROLL_POSTS_DETAILS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_DETAILS],
            self::COMPONENT_SCROLL_TAGS_DETAILS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_TAGS_DETAILS],
            self::COMPONENT_SCROLL_USERS_DETAILS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USERS_DETAILS],
            self::COMPONENT_SCROLL_USER_DETAILS => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USER_DETAILS],
            self::COMPONENT_SCROLL_CONTENT_SIMPLEVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_CONTENT_SIMPLEVIEW],
            self::COMPONENT_SCROLL_POSTS_SIMPLEVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_SIMPLEVIEW],
            self::COMPONENT_SCROLL_CONTENT_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_CONTENT_FULLVIEW],
            self::COMPONENT_SCROLL_HIGHLIGHTS_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_HIGHLIGHTS_FULLVIEW],
            self::COMPONENT_SCROLL_POSTS_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_FULLVIEW],
            self::COMPONENT_SCROLL_USERS_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USERS_FULLVIEW],
            self::COMPONENT_SCROLL_USER_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USER_FULLVIEW],
            self::COMPONENT_SCROLL_CONTENT_THUMBNAIL => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_CONTENT_THUMBNAIL],
            self::COMPONENT_SCROLL_HIGHLIGHTS_THUMBNAIL => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_HIGHLIGHTS_THUMBNAIL],
            self::COMPONENT_SCROLL_POSTS_THUMBNAIL => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_THUMBNAIL],
            self::COMPONENT_SCROLL_USERS_THUMBNAIL => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USERS_THUMBNAIL],
            self::COMPONENT_SCROLL_USER_THUMBNAIL => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USER_THUMBNAIL],
            self::COMPONENT_SCROLL_CONTENT_LIST => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_CONTENT_LIST],
            self::COMPONENT_SCROLL_HIGHLIGHTS_LIST => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_HIGHLIGHTS_LIST],
            self::COMPONENT_SCROLL_POSTS_LIST => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_LIST],
            self::COMPONENT_SCROLL_USERS_LIST => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USERS_LIST],
            self::COMPONENT_SCROLL_USER_LIST => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_USER_LIST],
            self::COMPONENT_SCROLL_TAGS_LIST => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_TAGS_LIST],
            self::COMPONENT_SCROLL_POSTS_LINE => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_POSTS_LINE],
            self::COMPONENT_SCROLL_AUTHORCONTENT_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_AUTHORCONTENT_FULLVIEW],
            self::COMPONENT_SCROLL_AUTHORHIGHLIGHTS_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_AUTHORHIGHLIGHTS_FULLVIEW],
            self::COMPONENT_SCROLL_AUTHORPOSTS_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_AUTHORPOSTS_FULLVIEW],
            self::COMPONENT_SCROLL_SINGLERELATEDCONTENT_FULLVIEW => [PoP_Module_Processor_CustomScrollInners::class, PoP_Module_Processor_CustomScrollInners::COMPONENT_SCROLLINNER_SINGLERELATEDCONTENT_FULLVIEW],
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
            self::COMPONENT_SCROLL_CONTENT_THUMBNAIL,
            self::COMPONENT_SCROLL_POSTS_THUMBNAIL,

            self::COMPONENT_SCROLL_USERS_THUMBNAIL,
            self::COMPONENT_SCROLL_USER_THUMBNAIL,
        );
        $independentitem_thumbnails = array(
            self::COMPONENT_SCROLL_HIGHLIGHTS_THUMBNAIL,
        );
        $lists = array(
            self::COMPONENT_SCROLL_CONTENT_LIST,
            self::COMPONENT_SCROLL_TAGS_LIST,
            self::COMPONENT_SCROLL_POSTS_LIST,

            self::COMPONENT_SCROLL_USERS_LIST,
            self::COMPONENT_SCROLL_USER_LIST,
        );
        $independentitem_lists = array(
            self::COMPONENT_SCROLL_HIGHLIGHTS_LIST,
        );
        $lines = array(
            self::COMPONENT_SCROLL_POSTS_LINE,
        );
        $details = array(
            self::COMPONENT_SCROLL_CONTENT_DETAILS,
            self::COMPONENT_SCROLL_POSTS_DETAILS,
            self::COMPONENT_SCROLL_TAGS_DETAILS,

            self::COMPONENT_SCROLL_USERS_DETAILS,
            self::COMPONENT_SCROLL_USER_DETAILS,
        );
        $navigators = array(
            self::COMPONENT_SCROLL_CONTENT_NAVIGATOR,
            self::COMPONENT_SCROLL_HIGHLIGHTS_NAVIGATOR,
            self::COMPONENT_SCROLL_POSTS_NAVIGATOR,
            self::COMPONENT_SCROLL_USERS_NAVIGATOR,
            self::COMPONENT_SCROLL_USER_NAVIGATOR,
        );
        $addons = array(
            self::COMPONENT_SCROLL_CONTENT_ADDONS,
            self::COMPONENT_SCROLL_HIGHLIGHTS_ADDONS,
            self::COMPONENT_SCROLL_POSTS_ADDONS,
            self::COMPONENT_SCROLL_USERS_ADDONS,
            self::COMPONENT_SCROLL_USER_ADDONS,
        );
        $simpleviews = array(
            self::COMPONENT_SCROLL_CONTENT_SIMPLEVIEW,
            self::COMPONENT_SCROLL_POSTS_SIMPLEVIEW,
        );
        $fullviews = array(
            self::COMPONENT_SCROLL_CONTENT_FULLVIEW,
            self::COMPONENT_SCROLL_HIGHLIGHTS_FULLVIEW,
            self::COMPONENT_SCROLL_POSTS_FULLVIEW,

            self::COMPONENT_SCROLL_USERS_FULLVIEW,
            self::COMPONENT_SCROLL_USER_FULLVIEW,

            self::COMPONENT_SCROLL_AUTHORCONTENT_FULLVIEW,
            self::COMPONENT_SCROLL_AUTHORHIGHLIGHTS_FULLVIEW,
            self::COMPONENT_SCROLL_AUTHORPOSTS_FULLVIEW,

            self::COMPONENT_SCROLL_SINGLERELATEDCONTENT_FULLVIEW,
        );

        $extra_class = '';
        if (in_array($component, $navigators)) {
            $extra_class = 'navigator text-inverse';
        } elseif (in_array($component, $addons)) {
            $extra_class = 'addons';
        } elseif (in_array($component, $simpleviews)) {
            $extra_class = 'simpleview';
        } elseif (in_array($component, $fullviews)) {
            $extra_class = 'fullview';
        } elseif (in_array($component, $details)) {
            $extra_class = 'details';
        } elseif (in_array($component, $thumbnails)) {
            $extra_class = 'thumb';
        } elseif (in_array($component, $independentitem_thumbnails)) {
            $extra_class = 'thumb independent';
        } elseif (in_array($component, $lists)) {
            $extra_class = 'list';
        } elseif (in_array($component, $independentitem_lists)) {
            $extra_class = 'list independent';
        } elseif (in_array($component, $lines)) {
            $extra_class = 'line';
        }
        $this->appendProp($component, $props, 'class', $extra_class);


        $inner = $this->getInnerSubcomponent($component);
        if (in_array($component, $navigators)) {
            // Make it activeItem: highlight on viewing the corresponding fullview
            $this->appendProp($inner, $props, 'class', 'pop-activeitem');
        }

        parent::initModelProps($component, $props);
    }
}


