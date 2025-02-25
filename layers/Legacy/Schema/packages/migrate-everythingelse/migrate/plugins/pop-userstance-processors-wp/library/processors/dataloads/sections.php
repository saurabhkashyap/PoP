<?php

class UserStance_WP_Module_Processor_CustomSectionDataloads extends UserStance_Module_Processor_CustomSectionDataloads
{
    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DATALOAD_AUTHORSTANCES_CAROUSEL,
        );
    }

    protected function getImmutableDataloadQueryArgs(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableDataloadQueryArgs($component, $props);
        
        switch ($component->name) {
            // Order the Author Thoughts Carousel, so that it always shows the General thought first, and the then article-related ones
            case self::COMPONENT_DATALOAD_AUTHORSTANCES_CAROUSEL:
                // General thought: menu_order = 0. Article-related thought: menu_order = 1. So order ASC.
                $ret['orderby'] = [
                  'menu_order' => 'ASC', 
                  'date' => 'DESC',
                ];
                break;
        }

        return $ret;
    }
}

