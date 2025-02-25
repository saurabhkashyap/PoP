<?php

class PoPVP_Module_Processor_SidebarMultiples extends PoP_Module_Processor_SidebarMultiplesBase
{
    public final const COMPONENT_MULTIPLE_SECTION_MYSTANCES_SIDEBAR = 'multiple-section-mystances-sidebar';
    public final const COMPONENT_MULTIPLE_SECTION_STANCES_AUTHORROLE_SIDEBAR = 'multiple-section-stances-authorrole-sidebar';
    public final const COMPONENT_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR = 'multiple-section-stances-generalstance-sidebar';
    public final const COMPONENT_MULTIPLE_SECTION_STANCES_SIDEBAR = 'multiple-section-stances-sidebar';
    public final const COMPONENT_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR = 'multiple-section-stances-stance-sidebar';
    public final const COMPONENT_MULTIPLE_TAG_STANCES_SIDEBAR = 'multiple-tag-stances-sidebar';
    public final const COMPONENT_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR = 'multiple-tag-stances-stance-sidebar';
    public final const COMPONENT_MULTIPLE_AUTHOR_STANCES_SIDEBAR = 'multiple-author-stances-sidebar';
    public final const COMPONENT_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR = 'multiple-author-stances-stance-sidebar';
    public final const COMPONENT_MULTIPLE_SINGLE_STANCE_SIDEBAR = 'multiple-single-stance-sidebar';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_MULTIPLE_SECTION_STANCES_SIDEBAR,
            self::COMPONENT_MULTIPLE_SECTION_MYSTANCES_SIDEBAR,
            self::COMPONENT_MULTIPLE_SECTION_STANCES_AUTHORROLE_SIDEBAR,
            self::COMPONENT_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR,
            self::COMPONENT_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR,
            self::COMPONENT_MULTIPLE_TAG_STANCES_SIDEBAR,
            self::COMPONENT_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR,
            self::COMPONENT_MULTIPLE_AUTHOR_STANCES_SIDEBAR,
            self::COMPONENT_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR,
            self::COMPONENT_MULTIPLE_SINGLE_STANCE_SIDEBAR,
        );
    }

    public function getInnerSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        $inners = array(
            self::COMPONENT_MULTIPLE_SECTION_STANCES_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_STANCES_SIDEBAR],
            self::COMPONENT_MULTIPLE_SECTION_MYSTANCES_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_MYSTANCES_SIDEBAR],
            self::COMPONENT_MULTIPLE_SECTION_STANCES_AUTHORROLE_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_STANCES_AUTHORROLE_SIDEBAR],
            self::COMPONENT_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_STANCES_STANCE_SIDEBAR],
            self::COMPONENT_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_STANCES_GENERALSTANCE_SIDEBAR],
            self::COMPONENT_MULTIPLE_TAG_STANCES_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_TAGSTANCES_SIDEBAR],
            self::COMPONENT_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_TAGSTANCES_STANCE_SIDEBAR],
            self::COMPONENT_MULTIPLE_AUTHOR_STANCES_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_AUTHORSTANCES_SIDEBAR],
            self::COMPONENT_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR => [PoPVP_Module_Processor_CustomSectionSidebarInners::class, PoPVP_Module_Processor_CustomSectionSidebarInners::COMPONENT_MULTIPLE_SECTIONINNER_AUTHORSTANCES_STANCE_SIDEBAR],
            self::COMPONENT_MULTIPLE_SINGLE_STANCE_SIDEBAR => [UserStance_Module_Processor_CustomSidebarDataloads::class, UserStance_Module_Processor_CustomSidebarDataloads::COMPONENT_DATALOAD_SINGLE_STANCE_SIDEBAR],
        );
        if ($inner = $inners[$component->name] ?? null) {
            $ret[] = $inner;
        }

        switch ($component->name) {
            case self::COMPONENT_MULTIPLE_AUTHOR_STANCES_SIDEBAR:
            case self::COMPONENT_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR:
                $ret = \PoP\Root\App::applyFilters(
                    'PoPVP_Module_Processor_SidebarMultiples:inner-modules:authorstances',
                    $ret
                );
                break;
        }

        return $ret;
    }

    public function getScreen(\PoP\ComponentModel\Component\Component $component)
    {
        $screens = array(
            self::COMPONENT_MULTIPLE_SECTION_STANCES_SIDEBAR => POP_SCREEN_SECTION,
            self::COMPONENT_MULTIPLE_SECTION_MYSTANCES_SIDEBAR => POP_SCREEN_SECTION,
            self::COMPONENT_MULTIPLE_SECTION_STANCES_AUTHORROLE_SIDEBAR => POP_SCREEN_SECTION,
            self::COMPONENT_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR => POP_SCREEN_SECTION,
            self::COMPONENT_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR => POP_SCREEN_SECTION,
            self::COMPONENT_MULTIPLE_TAG_STANCES_SIDEBAR => POP_SCREEN_TAGSECTION,
            self::COMPONENT_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR => POP_SCREEN_TAGSECTION,
            self::COMPONENT_MULTIPLE_AUTHOR_STANCES_SIDEBAR => POP_SCREEN_AUTHORSECTION,
            self::COMPONENT_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR => POP_SCREEN_AUTHORSECTION,
            self::COMPONENT_MULTIPLE_SINGLE_STANCE_SIDEBAR => POP_SCREEN_SINGLE,
        );
        if ($screen = $screens[$component->name] ?? null) {
            return $screen;
        }

        return parent::getScreen($component);
    }

    public function getScreengroup(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_MULTIPLE_SECTION_STANCES_SIDEBAR:
            case self::COMPONENT_MULTIPLE_SECTION_STANCES_AUTHORROLE_SIDEBAR:
            case self::COMPONENT_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR:
            case self::COMPONENT_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR:
            case self::COMPONENT_MULTIPLE_TAG_STANCES_SIDEBAR:
            case self::COMPONENT_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR:
            case self::COMPONENT_MULTIPLE_AUTHOR_STANCES_SIDEBAR:
            case self::COMPONENT_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR:
            case self::COMPONENT_MULTIPLE_SINGLE_STANCE_SIDEBAR:
                return POP_SCREENGROUP_CONTENTREAD;

            case self::COMPONENT_MULTIPLE_SECTION_MYSTANCES_SIDEBAR:
                return POP_SCREENGROUP_CONTENTWRITE;
        }

        return parent::getScreengroup($component);
    }

    public function initWebPlatformModelProps(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_MULTIPLE_SINGLE_STANCE_SIDEBAR:
                $inners = array(
                    self::COMPONENT_MULTIPLE_SINGLE_STANCE_SIDEBAR => [UserStance_Module_Processor_CustomSidebarDataloads::class, UserStance_Module_Processor_CustomSidebarDataloads::COMPONENT_DATALOAD_SINGLE_STANCE_SIDEBAR],
                );
                $subcomponent = $inners[$component->name];

                // Comment Leo 10/12/2016: in the past, we did .active, however that doesn't work anymore for when alt+click to open a link, instead must pick the last added .tab-pane with selector "last-child"
                $mainblock_taget = '#'.POP_COMPONENTID_PAGESECTIONCONTAINERID_BODY.' .pop-pagesection-page.toplevel:last-child > .blockgroup-singlepost > .blocksection-extensions > .pop-block > .blocksection-inners .content-single';

                // Make the block be collapsible, open it when the main feed is reached, with waypoints
                $this->appendProp([$subcomponent], $props, 'class', 'collapse');
                $this->mergeProp(
                    [$subcomponent],
                    $props,
                    'params',
                    array(
                        'data-collapse-target' => $mainblock_taget
                    )
                );
                $this->mergeJsmethodsProp([$subcomponent], $props, array('waypointsToggleCollapse'));
                break;
        }

        parent::initWebPlatformModelProps($component, $props);
    }
}


