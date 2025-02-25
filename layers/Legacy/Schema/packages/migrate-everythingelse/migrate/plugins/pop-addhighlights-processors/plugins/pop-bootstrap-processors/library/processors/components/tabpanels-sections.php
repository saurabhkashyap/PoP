<?php

class PoP_AddHighlights_Module_Processor_SectionTabPanelComponents extends PoP_Module_Processor_SectionTabPanelComponentsBase
{
    public final const COMPONENT_TABPANEL_HIGHLIGHTS = 'tabpanel-highlights';
    public final const COMPONENT_TABPANEL_MYHIGHLIGHTS = 'tabpanel-myhighlights';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_TABPANEL_HIGHLIGHTS,
            self::COMPONENT_TABPANEL_MYHIGHLIGHTS,
        );
    }

    protected function getDefaultActivepanelFormat(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_TABPANEL_HIGHLIGHTS:
                return PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_HIGHLIGHTS);

            case self::COMPONENT_TABPANEL_MYHIGHLIGHTS:
                return PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_MYHIGHLIGHTS);
        }

        return parent::getDefaultActivepanelFormat($component);
    }

    public function getPanelSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getPanelSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_TABPANEL_HIGHLIGHTS:
                $ret = array_merge(
                    $ret,
                    array(
                        [PoP_AddHighlights_Module_Processor_CustomSectionDataloads::class, PoP_AddHighlights_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW],
                        // self::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_DETAILS,
                        [PoP_AddHighlights_Module_Processor_CustomSectionDataloads::class, PoP_AddHighlights_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST],
                        [PoP_AddHighlights_Module_Processor_CustomSectionDataloads::class, PoP_AddHighlights_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL],
                    )
                );
                break;
        }

        return $ret;
    }

    public function getPanelHeaders(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_TABPANEL_HIGHLIGHTS:
                $ret = array(
                    [
                        'header-subcomponent' => [PoP_AddHighlights_Module_Processor_CustomSectionDataloads::class, PoP_AddHighlights_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_FULLVIEW],
                    ],
                    [
                        'header-subcomponent' => [PoP_AddHighlights_Module_Processor_CustomSectionDataloads::class, PoP_AddHighlights_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST],
                        'subheader-subcomponents' =>  array(
                            [PoP_AddHighlights_Module_Processor_CustomSectionDataloads::class, PoP_AddHighlights_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_LIST],
                            [PoP_AddHighlights_Module_Processor_CustomSectionDataloads::class, PoP_AddHighlights_Module_Processor_CustomSectionDataloads::COMPONENT_DATALOAD_HIGHLIGHTS_SCROLL_THUMBNAIL],
                        ),
                    ],
                );
                break;
        }

        return parent::getPanelHeaders($component, $props);
    }
}


