<?php

class PoP_Module_Processor_HighlightedPostSubcomponentLayouts extends PoP_Module_Processor_HighlightedPostSubcomponentLayoutsBase
{
    public final const COMPONENT_LAYOUT_HIGHLIGHTEDPOST_LINE = 'layout-highlightedpost-line';
    public final const COMPONENT_LAYOUT_HIGHLIGHTEDPOST_ADDONS = 'layout-highlightedpost-addons';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUT_HIGHLIGHTEDPOST_LINE,
            self::COMPONENT_LAYOUT_HIGHLIGHTEDPOST_ADDONS,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getLayoutSubcomponents($component);

        $layouts = array(
            self::COMPONENT_LAYOUT_HIGHLIGHTEDPOST_LINE => [PoP_Module_Processor_MultiplePostLayouts::class, PoP_Module_Processor_MultiplePostLayouts::COMPONENT_LAYOUT_MULTIPLECONTENT_LINE],
            self::COMPONENT_LAYOUT_HIGHLIGHTEDPOST_ADDONS => [PoP_Module_Processor_MultiplePostLayouts::class, PoP_Module_Processor_MultiplePostLayouts::COMPONENT_LAYOUT_MULTIPLECONTENT_ADDONS],
        );
        if ($layout = $layouts[$component->name] ?? null) {
            $ret[] = $layout;
        }

        return $ret;
    }
}



