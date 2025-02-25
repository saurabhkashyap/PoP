<?php

class PoP_EventsCreation_Module_Processor_CustomDelegatorFilters extends PoP_Module_Processor_CustomDelegatorFiltersBase
{
    public final const COMPONENT_DELEGATORFILTER_MYEVENTS = 'delegatorfilter-myevents';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DELEGATORFILTER_MYEVENTS,
        );
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inners = array(
            self::COMPONENT_DELEGATORFILTER_MYEVENTS => [PoP_EventsCreation_Module_Processor_CustomSimpleFilterInners::class, PoP_EventsCreation_Module_Processor_CustomSimpleFilterInners::COMPONENT_SIMPLEFILTERINPUTCONTAINER_MYEVENTS],
        );

        if ($inner = $inners[$component->name] ?? null) {
            return $inner;
        }

        return parent::getInnerSubcomponent($component);
    }
}



