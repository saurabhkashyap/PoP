<?php
use PoPCMSSchema\Users\ModuleConfiguration as UsersModuleConfiguration;

class GD_EM_Module_Processor_CustomScrollMapSectionBlocks extends GD_EM_Module_Processor_ScrollMapBlocksBase
{
    public final const MODULE_BLOCK_SEARCHUSERS_SCROLLMAP = 'block-searchusers-scrollmap';
    public final const MODULE_BLOCK_USERS_SCROLLMAP = 'block-users-scrollmap';
    public final const MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP = 'block-users-horizontalscrollmap';
    public final const MODULE_BLOCK_EVENTS_SCROLLMAP = 'block-events-scrollmap';
    public final const MODULE_BLOCK_PASTEVENTS_SCROLLMAP = 'block-pastevents-scrollmap';
    public final const MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP = 'block-events-horizontalscrollmap';
    public final const MODULE_BLOCK_AUTHOREVENTS_SCROLLMAP = 'block-authorevents-scrollmap';
    public final const MODULE_BLOCK_AUTHORPASTEVENTS_SCROLLMAP = 'block-authorpastevents-scrollmap';
    public final const MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP = 'block-authorevents-horizontalscrollmap';
    public final const MODULE_BLOCK_TAGEVENTS_SCROLLMAP = 'block-tagevents-scrollmap';
    public final const MODULE_BLOCK_TAGPASTEVENTS_SCROLLMAP = 'block-tagpastevents-scrollmap';
    public final const MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP = 'block-tagevents-horizontalscrollmap';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BLOCK_EVENTS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_PASTEVENTS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP],
            [self::class, self::MODULE_BLOCK_SEARCHUSERS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_USERS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP],
            [self::class, self::MODULE_BLOCK_AUTHOREVENTS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_AUTHORPASTEVENTS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP],
            [self::class, self::MODULE_BLOCK_TAGEVENTS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_TAGPASTEVENTS_SCROLLMAP],
            [self::class, self::MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP],
        );
    }

    public function getRelevantRoute(array $componentVariation, array &$props): ?string
    {
        return match($componentVariation[1]) {
            self::MODULE_BLOCK_SEARCHUSERS_SCROLLMAP => POP_BLOG_ROUTE_SEARCHUSERS,
            self::MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP => UsersModuleConfiguration::getUsersRoute(),
            self::MODULE_BLOCK_USERS_SCROLLMAP => UsersModuleConfiguration::getUsersRoute(),
            default => parent::getRelevantRoute($componentVariation, $props),
        };
    }

    protected function getInnerSubmodule(array $componentVariation)
    {
        $inner_modules = array(
            self::MODULE_BLOCK_SEARCHUSERS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_SEARCHUSERS_SCROLLMAP],
            self::MODULE_BLOCK_USERS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_USERS_SCROLLMAP],
            self::MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_USERS_HORIZONTALSCROLLMAP],
            self::MODULE_BLOCK_EVENTS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_EVENTS_SCROLLMAP],
            self::MODULE_BLOCK_PASTEVENTS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_PASTEVENTS_SCROLLMAP],
            self::MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_EVENTS_HORIZONTALSCROLLMAP],
            self::MODULE_BLOCK_AUTHOREVENTS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_AUTHOREVENTS_SCROLLMAP],
            self::MODULE_BLOCK_AUTHORPASTEVENTS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_AUTHORPASTEVENTS_SCROLLMAP],
            self::MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_AUTHOREVENTS_HORIZONTALSCROLLMAP],
            self::MODULE_BLOCK_TAGEVENTS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_TAGEVENTS_SCROLLMAP],
            self::MODULE_BLOCK_TAGPASTEVENTS_SCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_TAGPASTEVENTS_SCROLLMAP],
            self::MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::MODULE_DATALOAD_TAGEVENTS_HORIZONTALSCROLLMAP],
        );

        return $inner_modules[$componentVariation[1]] ?? null;
    }

    public function getTitle(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_AUTHOREVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_AUTHORPASTEVENTS_SCROLLMAP:
                return PoP_Module_Processor_CustomSectionBlocksUtils::getAuthorTitle();

            case self::MODULE_BLOCK_TAGEVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_TAGPASTEVENTS_SCROLLMAP:
                return PoP_Module_Processor_CustomSectionBlocksUtils::getTagTitle();
        }

        return parent::getTitle($componentVariation, $props);
    }

    protected function getControlgroupTopSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_EVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_PASTEVENTS_SCROLLMAP:
                return [PoP_Events_Module_Processor_CustomControlGroups::class, PoP_Events_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKEVENTLIST];

            case self::MODULE_BLOCK_AUTHOREVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_AUTHORPASTEVENTS_SCROLLMAP:
                return [PoP_Events_Module_Processor_CustomControlGroups::class, PoP_Events_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKAUTHOREVENTLIST];

            case self::MODULE_BLOCK_TAGEVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_TAGPASTEVENTS_SCROLLMAP:
                return [PoP_Events_Module_Processor_CustomControlGroups::class, PoP_Events_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKTAGEVENTLIST];

            case self::MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP:
                return [PoP_Locations_Module_Processor_CustomControlGroups::class, PoP_Locations_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKMAPPOSTLIST];

            case self::MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP:
                return [PoP_Locations_Module_Processor_CustomControlGroups::class, PoP_Locations_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKAUTHORMAPPOSTLIST];

            case self::MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP:
                return [PoP_Locations_Module_Processor_CustomControlGroups::class, PoP_Locations_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKTAGMAPPOSTLIST];

            case self::MODULE_BLOCK_SEARCHUSERS_SCROLLMAP:
            case self::MODULE_BLOCK_USERS_SCROLLMAP:
                return [PoP_Module_Processor_CustomControlGroups::class, PoP_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKUSERLIST];

            case self::MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP:
                return [PoP_Locations_Module_Processor_CustomControlGroups::class, PoP_Locations_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKMAPUSERLIST];
        }

        return parent::getControlgroupTopSubmodule($componentVariation);
    }

    protected function getModuleTogglemapanchorcontrolPath(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP:
                $users_events_path = array(
                    $this->getControlgroupTopSubmodule($componentVariation),
                    [PoP_Locations_Module_Processor_CustomControlButtonGroups::class, PoP_Locations_Module_Processor_CustomControlButtonGroups::MODULE_CONTROLBUTTONGROUP_TOGGLEMAP],
                    [PoP_Locations_Module_Processor_CustomAnchorControls::class, PoP_Locations_Module_Processor_CustomAnchorControls::MODULE_ANCHORCONTROL_TOGGLEMAP],
                );
                $paths = array(
                    self::MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP => $users_events_path,
                    self::MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP => $users_events_path,
                    self::MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP => array(
                        [PoP_Locations_Module_Processor_CustomControlGroups::class, PoP_Locations_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKAUTHORMAPPOSTLIST],
                        [PoP_Locations_Module_Processor_CustomControlButtonGroups::class, PoP_Locations_Module_Processor_CustomControlButtonGroups::MODULE_CONTROLBUTTONGROUP_TOGGLEAUTHORMAP],
                        [PoP_Locations_Module_Processor_CustomAnchorControls::class, PoP_Locations_Module_Processor_CustomAnchorControls::MODULE_ANCHORCONTROL_TOGGLEAUTHORMAP],
                    ),
                    self::MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP => array(
                        [PoP_Locations_Module_Processor_CustomControlGroups::class, PoP_Locations_Module_Processor_CustomControlGroups::MODULE_CONTROLGROUP_BLOCKTAGMAPPOSTLIST],
                        [PoP_Locations_Module_Processor_CustomControlButtonGroups::class, PoP_Locations_Module_Processor_CustomControlButtonGroups::MODULE_CONTROLBUTTONGROUP_TOGGLETAGMAP],
                        [PoP_Locations_Module_Processor_CustomAnchorControls::class, PoP_Locations_Module_Processor_CustomAnchorControls::MODULE_ANCHORCONTROL_TOGGLETAGMAP],
                    ),
                );
                return $paths[$componentVariation[1]];
        }

        return null;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_EVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_AUTHOREVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_TAGEVENTS_SCROLLMAP:
            case self::MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP:
                $this->appendProp($componentVariation, $props, 'class', 'block-events-scrollmap');
                break;
        }

        parent::initModelProps($componentVariation, $props);
    }

    public function initWebPlatformModelProps(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_EVENTS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_USERS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_AUTHOREVENTS_HORIZONTALSCROLLMAP:
            case self::MODULE_BLOCK_TAGEVENTS_HORIZONTALSCROLLMAP:
                if ($path = $this->getModuleTogglemapanchorcontrolPath($componentVariation)) {
                    $this->setProp(
                        $path,
                        $props,
                        'target',
                        '#'.$this->getFrontendId($componentVariation, $props).' > .blocksection-inners .collapse.map'
                    );
                }
                break;
        }

        parent::initWebPlatformModelProps($componentVariation, $props);
    }
}



