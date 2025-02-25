<?php

class PoP_Locations_Module_Processor_CustomDelegatorFilters extends PoP_Module_Processor_CustomDelegatorFiltersBase
{
    public final const COMPONENT_DELEGATORFILTER_LOCATIONS = 'delegatorfilter-locations';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DELEGATORFILTER_LOCATIONS,
        );
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inners = array(
            self::COMPONENT_DELEGATORFILTER_LOCATIONS => [PoP_Locations_Module_Processor_CustomSimpleFilterInners::class, PoP_Locations_Module_Processor_CustomSimpleFilterInners::COMPONENT_SIMPLEFILTERINPUTCONTAINER_LOCATIONS],
        );

        if ($inner = $inners[$component->name] ?? null) {
            return $inner;
        }

        return parent::getInnerSubcomponent($component);
    }
}



