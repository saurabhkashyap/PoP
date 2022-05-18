<?php
use PoP\ComponentModel\State\ApplicationState;

class PoP_Blog_Module_Processor_SidebarMultiples extends PoP_Module_Processor_SidebarMultiplesBase
{
    public final const MODULE_MULTIPLE_AUTHOR_SIDEBAR = 'multiple-author-sidebar';
    public final const MODULE_MULTIPLE_AUTHORMAINCONTENT_SIDEBAR = 'multiple-authormaincontent-sidebar';
    public final const MODULE_MULTIPLE_AUTHORCONTENT_SIDEBAR = 'multiple-authorcontent-sidebar';
    public final const MODULE_MULTIPLE_AUTHORPOSTS_SIDEBAR = 'multiple-authorposts-sidebar';
    public final const MODULE_MULTIPLE_AUTHORCATEGORYPOSTS_SIDEBAR = 'multiple-authorcategoryposts-sidebar';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_MULTIPLE_AUTHOR_SIDEBAR],
            [self::class, self::MODULE_MULTIPLE_AUTHORMAINCONTENT_SIDEBAR],
            [self::class, self::MODULE_MULTIPLE_AUTHORCONTENT_SIDEBAR],
            [self::class, self::MODULE_MULTIPLE_AUTHORPOSTS_SIDEBAR],
            [self::class, self::MODULE_MULTIPLE_AUTHORCATEGORYPOSTS_SIDEBAR],
        );
    }

    public function getInnerSubmodules(array $componentVariation): array
    {
        $ret = parent::getInnerSubmodules($componentVariation);

        switch ($componentVariation[1]) {
         // Add also the filter block for the Single Related Content, etc
            case self::MODULE_MULTIPLE_AUTHOR_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORMAINCONTENT_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORCONTENT_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORPOSTS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORCATEGORYPOSTS_SIDEBAR:
                $author = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                $filters = array(
                    self::MODULE_MULTIPLE_AUTHOR_SIDEBAR => null,
                    self::MODULE_MULTIPLE_AUTHORMAINCONTENT_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_AUTHORSECTIONINNER_MAINCONTENT_SIDEBAR],
                    self::MODULE_MULTIPLE_AUTHORCONTENT_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_AUTHORSECTIONINNER_CONTENT_SIDEBAR],
                    self::MODULE_MULTIPLE_AUTHORPOSTS_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_AUTHORSECTIONINNER_POSTS_SIDEBAR],
                    self::MODULE_MULTIPLE_AUTHORCATEGORYPOSTS_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_AUTHORSECTIONINNER_CATEGORYPOSTS_SIDEBAR],
                );
                if ($filter = $filters[$componentVariation[1]] ?? null) {
                    $ret[] = $filter;
                }

                // Allow URE to add the Organization/Individual sidebars below
                $ret = \PoP\Root\App::applyFilters(
                    'PoP_UserCommunities_Module_Processor_SidebarMultiples:sidebar-layouts',
                    $ret,
                    $author,
                    $componentVariation
                );
                break;
        }

        return $ret;
    }

    public function getScreen(array $componentVariation)
    {
        $screens = array(
            self::MODULE_MULTIPLE_AUTHOR_SIDEBAR => POP_SCREEN_AUTHOR,
            self::MODULE_MULTIPLE_AUTHORMAINCONTENT_SIDEBAR => POP_SCREEN_AUTHORSECTION,
            self::MODULE_MULTIPLE_AUTHORCONTENT_SIDEBAR => POP_SCREEN_AUTHORSECTION,
            self::MODULE_MULTIPLE_AUTHORPOSTS_SIDEBAR => POP_SCREEN_AUTHORSECTION,
            self::MODULE_MULTIPLE_AUTHORCATEGORYPOSTS_SIDEBAR => POP_SCREEN_AUTHORSECTION,
        );
        if ($screen = $screens[$componentVariation[1]] ?? null) {
            return $screen;
        }

        return parent::getScreen($componentVariation);
    }

    public function getScreengroup(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_MULTIPLE_AUTHOR_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORMAINCONTENT_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORCONTENT_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORPOSTS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORCATEGORYPOSTS_SIDEBAR:
                return POP_SCREENGROUP_CONTENTREAD;
        }

        return parent::getScreengroup($componentVariation);
    }

    public function initWebPlatformModelProps(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_MULTIPLE_AUTHORMAINCONTENT_SIDEBAR:
                $subComponentVariations = array_diff(
                    $this->getSubComponentVariations($componentVariation),
                    $this->getPermanentSubmodules($componentVariation)
                );
                foreach ($subComponentVariations as $subComponentVariation) {
                      // Comment Leo 10/12/2016: in the past, we did .active, however that doesn't work anymore for when alt+click to open a link, instead must pick the last added .tab-pane with selector "last-child"
                    $mainblock_taget = '#'.POP_MODULEID_PAGESECTIONCONTAINERID_BODY.' .pop-pagesection-page.toplevel:last-child > .blockgroup-author > .blocksection-extensions > .pop-block.withfilter';

                    // Make the block be collapsible, open it when the main feed is reached, with waypoints
                    $this->appendProp([$subComponentVariation], $props, 'class', 'collapse');
                    $this->mergeProp(
                        [$subComponentVariation],
                        $props,
                        'params',
                        array(
                            'data-collapse-target' => $mainblock_taget
                        )
                    );
                    $this->mergeJsmethodsProp([$subComponentVariation], $props, array('waypointsToggleCollapse'));
                }
                break;
        }

        parent::initWebPlatformModelProps($componentVariation, $props);
    }
}


