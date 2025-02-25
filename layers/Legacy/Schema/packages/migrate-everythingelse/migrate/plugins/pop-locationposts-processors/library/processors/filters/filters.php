<?php

class PoP_LocationPosts_Module_Processor_CustomFilters extends PoP_Module_Processor_FiltersBase
{
    public final const COMPONENT_FILTER_AUTHORLOCATIONPOSTS = 'filter-authorlocationposts';
    public final const COMPONENT_FILTER_TAGLOCATIONPOSTS = 'filter-taglocationposts';
    public final const COMPONENT_FILTER_LOCATIONPOSTS = 'filter-locationposts';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FILTER_LOCATIONPOSTS,
            self::COMPONENT_FILTER_AUTHORLOCATIONPOSTS,
            self::COMPONENT_FILTER_TAGLOCATIONPOSTS,
        );
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inners = array(
            self::COMPONENT_FILTER_LOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_CustomFilterInners::class, PoP_LocationPosts_Module_Processor_CustomFilterInners::COMPONENT_FILTERINPUTCONTAINER_LOCATIONPOSTS],
            self::COMPONENT_FILTER_AUTHORLOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_CustomFilterInners::class, PoP_LocationPosts_Module_Processor_CustomFilterInners::COMPONENT_FILTERINPUTCONTAINER_AUTHORLOCATIONPOSTS],
            self::COMPONENT_FILTER_TAGLOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_CustomFilterInners::class, PoP_LocationPosts_Module_Processor_CustomFilterInners::COMPONENT_FILTERINPUTCONTAINER_TAGLOCATIONPOSTS],
        );

        if ($inner = $inners[$component->name] ?? null) {
            return $inner;
        }

        return parent::getInnerSubcomponent($component);
    }
}



