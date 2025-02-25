<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPCMSSchema\Users\Facades\UserTypeAPIFacade;

class PoP_Module_Processor_CustomContentBlocks extends PoP_Module_Processor_BlocksBase
{
    public final const COMPONENT_BLOCK_AUTHOR_CONTENT = 'block-author-content';
    public final const COMPONENT_BLOCK_AUTHOR_SUMMARYCONTENT = 'block-author-summarycontent';
    public final const COMPONENT_BLOCK_TAG_CONTENT = 'block-tag-content';
    public final const COMPONENT_BLOCK_SINGLE_CONTENT = 'block-single-content';
    public final const COMPONENT_BLOCK_PAGE_CONTENT = 'block-pageabout-content';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_BLOCK_AUTHOR_CONTENT,
            self::COMPONENT_BLOCK_AUTHOR_SUMMARYCONTENT,
            self::COMPONENT_BLOCK_TAG_CONTENT,
            self::COMPONENT_BLOCK_SINGLE_CONTENT,
            self::COMPONENT_BLOCK_PAGE_CONTENT,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            // The Page Content block uses whichever is the current page
            self::COMPONENT_BLOCK_PAGE_CONTENT => POP_ROUTE_DESCRIPTION,//\PoP\Root\App::getState('route'),
            self::COMPONENT_BLOCK_AUTHOR_CONTENT => POP_ROUTE_DESCRIPTION,
            self::COMPONENT_BLOCK_TAG_CONTENT => POP_ROUTE_DESCRIPTION,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    protected function getDescriptionBottom(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $userTypeAPI = UserTypeAPIFacade::getInstance();
        switch ($component->name) {
            case self::COMPONENT_BLOCK_AUTHOR_SUMMARYCONTENT:
                $author = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                $url = $userTypeAPI->getUserURL($author);
                return sprintf(
                    '<p class="text-center"><a href="%s">%s</a></p>',
                    $url,
                    TranslationAPIFacade::getInstance()->__('Go to Full Profile ', 'poptheme-wassup').'<i class="fa fa-fw fa-arrow-right"></i>'
                );
        }

        return parent::getDescriptionBottom($component, $props);
    }

    public function getTitle(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $userTypeAPI = UserTypeAPIFacade::getInstance();
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        switch ($component->name) {
            case self::COMPONENT_BLOCK_AUTHOR_CONTENT:
            case self::COMPONENT_BLOCK_AUTHOR_SUMMARYCONTENT:
                $author = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                return $userTypeAPI->getUserDisplayName($author);

            case self::COMPONENT_BLOCK_SINGLE_CONTENT:
            case self::COMPONENT_BLOCK_PAGE_CONTENT:
                $post_id = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                return $customPostTypeAPI->getTitle($post_id);
        }

        return parent::getTitle($component, $props);
    }

    protected function getControlgroupTopSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_PAGE_CONTENT:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::COMPONENT_CONTROLGROUP_SHARE];
        }

        return parent::getControlgroupTopSubcomponent($component);
    }

    protected function getInnerSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        $inners = array(
            self::COMPONENT_BLOCK_AUTHOR_CONTENT => [PoP_Module_Processor_CustomContentDataloads::class, PoP_Module_Processor_CustomContentDataloads::COMPONENT_DATALOAD_AUTHOR_CONTENT],
            self::COMPONENT_BLOCK_AUTHOR_SUMMARYCONTENT => [PoP_Module_Processor_CustomContentDataloads::class, PoP_Module_Processor_CustomContentDataloads::COMPONENT_DATALOAD_AUTHOR_SUMMARYCONTENT],
            self::COMPONENT_BLOCK_TAG_CONTENT => [PoP_Module_Processor_CustomContentDataloads::class, PoP_Module_Processor_CustomContentDataloads::COMPONENT_DATALOAD_TAG_CONTENT],
            self::COMPONENT_BLOCK_SINGLE_CONTENT => [PoP_Module_Processor_CustomContentDataloads::class, PoP_Module_Processor_CustomContentDataloads::COMPONENT_DATALOAD_SINGLE_CONTENT],
            self::COMPONENT_BLOCK_PAGE_CONTENT => [PoP_Module_Processor_CustomContentDataloads::class, PoP_Module_Processor_CustomContentDataloads::COMPONENT_DATALOAD_PAGE_CONTENT],
        );
        if ($inner = $inners[$component->name] ?? null) {
            $ret[] = $inner;
        }

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_TAG_CONTENT:
                $this->appendProp($component, $props, 'class', 'block-tag-content');
                break;

            case self::COMPONENT_BLOCK_PAGE_CONTENT:
                $this->appendProp($component, $props, 'class', 'block-singleabout-content');
                $inners = $this->getInnerSubcomponents($component);
                foreach ($inners as $inner) {
                    $this->appendProp($inner, $props, 'class', 'col-xs-12');
                }
                break;

            case self::COMPONENT_BLOCK_SINGLE_CONTENT:
                $this->appendProp($component, $props, 'class', 'block-single-content');
                break;
        }

        parent::initModelProps($component, $props);
    }

    public function initRequestProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        switch ($component->name) {
            case self::COMPONENT_BLOCK_SINGLE_CONTENT:
                
                // Also append the post_status, so we can hide the bottomsidebar for draft posts
                $post_id = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                $this->appendProp($component, $props, 'runtime-class', $customPostTypeAPI->getCustomPostType($post_id) . '-' . $post_id);
                $this->appendProp($component, $props, 'runtime-class', $customPostTypeAPI->getStatus($post_id));
                break;
        }

        parent::initRequestProps($component, $props);
    }

    protected function getBlocksectionsClasses(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getBlocksectionsClasses($component);

        switch ($component->name) {
            case self::COMPONENT_BLOCK_PAGE_CONTENT:
                $ret['blocksection-inners'] = 'row row-item';
                break;
        }

        return $ret;
    }

    // function getNature(\PoP\ComponentModel\Component\Component $component) {

    //     switch ($component->name) {

    //         case self::COMPONENT_BLOCK_AUTHOR_CONTENT:
    //         case self::COMPONENT_BLOCK_AUTHOR_SUMMARYCONTENT:

    //             return UserRequestNature::USER;

    //         case self::COMPONENT_BLOCK_TAG_CONTENT:

    //             return TagRequestNature::TAG;

    //         case self::COMPONENT_BLOCK_SINGLE_CONTENT:

    //             return CustomPostRequestNature::CUSTOMPOST;
    //     }

    //     return parent::getNature($component);
    // }
}



