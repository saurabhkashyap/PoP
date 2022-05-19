<?php

class GD_EM_Module_Processor_TagSectionTabPanelComponents extends PoP_Module_Processor_TagSectionTabPanelComponentsBase
{
    public final const COMPONENT_TABPANEL_TAGEVENTS = 'tabpanel-tagevents';
    public final const COMPONENT_TABPANEL_TAGPASTEVENTS = 'tabpanel-tagpastevents';
    public final const COMPONENT_TABPANEL_TAGEVENTSCALENDAR = 'tabpanel-tageventscalendar';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_TABPANEL_TAGEVENTS],
            [self::class, self::COMPONENT_TABPANEL_TAGPASTEVENTS],
            [self::class, self::COMPONENT_TABPANEL_TAGEVENTSCALENDAR],
        );
    }

    protected function getDefaultActivepanelFormat(array $component)
    {
        switch ($component[1]) {
            case self::COMPONENT_TABPANEL_TAGEVENTSCALENDAR:
                return PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_TAGSECTIONCALENDAR);
        }

        return parent::getDefaultActivepanelFormat($component);
    }

    public function getPanelSubcomponents(array $component)
    {
        $ret = parent::getPanelSubcomponents($component);

        switch ($component[1]) {
            case self::COMPONENT_TABPANEL_TAGEVENTS:
                $ret = array_merge(
                    $ret,
                    array(
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_SIMPLEVIEW],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_FULLVIEW],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_DETAILS],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_THUMBNAIL],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_LIST],
                        [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLLMAP],
                    )
                );
                break;

            case self::COMPONENT_TABPANEL_TAGPASTEVENTS:
                $ret = array_merge(
                    $ret,
                    array(
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_SIMPLEVIEW],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_FULLVIEW],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_DETAILS],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_THUMBNAIL],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_LIST],
                        [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLLMAP],
                    )
                );
                break;

            case self::COMPONENT_TABPANEL_TAGEVENTSCALENDAR:
                $ret = array_merge(
                    $ret,
                    array(
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTSCALENDAR_CALENDAR],
                        [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTSCALENDAR_CALENDARMAP],
                    )
                );
                break;
        }

        return $ret;
    }

    public function getPanelHeaders(array $component, array &$props)
    {
        switch ($component[1]) {
            case self::COMPONENT_TABPANEL_TAGEVENTS:
                $ret = array(
                    [
                        'header-subcomponent' => [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_SIMPLEVIEW],
                        'subheader-subcomponents' =>  array(
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_SIMPLEVIEW],
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_FULLVIEW],
                        ),
                    ],
                    [
                        'header-subcomponent' => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLLMAP],
                    ],
                    [
                        'header-subcomponent' => [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_LIST],
                        'subheader-subcomponents' =>  array(
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_DETAILS],
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_THUMBNAIL],
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGEVENTS_SCROLL_LIST],
                        ),
                    ],
                );
                break;

            case self::COMPONENT_TABPANEL_TAGPASTEVENTS:
                $ret = array(
                    [
                        'header-subcomponent' => [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_SIMPLEVIEW],
                        'subheader-subcomponents' =>  array(
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_SIMPLEVIEW],
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_FULLVIEW],
                        ),
                    ],
                    [
                        'header-subcomponent' => [GD_EM_Module_Processor_CustomScrollMapSectionDataloads::class, GD_EM_Module_Processor_CustomScrollMapSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLLMAP],
                    ],
                    [
                        'header-subcomponent' => [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_LIST],
                        'subheader-subcomponents' =>  array(
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_DETAILS],
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_THUMBNAIL],
                            [PoP_Events_Module_Processor_CustomSectionDataloads::class, PoP_Events_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_TAGPASTEVENTS_SCROLL_LIST],
                        ),
                    ],
                );
                break;
        }

        return $ret ?? parent::getPanelHeaders($component, $props);
    }
}


