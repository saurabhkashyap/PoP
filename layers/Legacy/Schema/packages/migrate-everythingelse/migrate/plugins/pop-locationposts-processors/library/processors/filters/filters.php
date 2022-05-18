<?php

class PoP_LocationPosts_Module_Processor_CustomFilters extends PoP_Module_Processor_FiltersBase
{
    public final const MODULE_FILTER_AUTHORLOCATIONPOSTS = 'filter-authorlocationposts';
    public final const MODULE_FILTER_TAGLOCATIONPOSTS = 'filter-taglocationposts';
    public final const MODULE_FILTER_LOCATIONPOSTS = 'filter-locationposts';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FILTER_LOCATIONPOSTS],
            [self::class, self::MODULE_FILTER_AUTHORLOCATIONPOSTS],
            [self::class, self::MODULE_FILTER_TAGLOCATIONPOSTS],
        );
    }

    public function getInnerSubmodule(array $componentVariation)
    {
        $inners = array(
            self::MODULE_FILTER_LOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_CustomFilterInners::class, PoP_LocationPosts_Module_Processor_CustomFilterInners::MODULE_FILTERINPUTCONTAINER_LOCATIONPOSTS],
            self::MODULE_FILTER_AUTHORLOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_CustomFilterInners::class, PoP_LocationPosts_Module_Processor_CustomFilterInners::MODULE_FILTERINPUTCONTAINER_AUTHORLOCATIONPOSTS],
            self::MODULE_FILTER_TAGLOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_CustomFilterInners::class, PoP_LocationPosts_Module_Processor_CustomFilterInners::MODULE_FILTERINPUTCONTAINER_TAGLOCATIONPOSTS],
        );

        if ($inner = $inners[$componentVariation[1]] ?? null) {
            return $inner;
        }

        return parent::getInnerSubmodule($componentVariation);
    }
}



