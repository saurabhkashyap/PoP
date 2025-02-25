<?php
use PoP\ComponentModel\Facades\ComponentPath\ComponentPathManagerFacade;
class GD_EM_Module_Processor_CreateLocationBlocks extends PoP_Module_Processor_BlocksBase
{
    public final const COMPONENT_BLOCK_CREATELOCATION = 'block-createlocation';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_BLOCK_CREATELOCATION,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            self::COMPONENT_BLOCK_CREATELOCATION => POP_ADDLOCATIONS_ROUTE_ADDLOCATION,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    protected function getInnerSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_BLOCK_CREATELOCATION:
                $ret[] = [GD_EM_Module_Processor_CreateLocationDataloads::class, GD_EM_Module_Processor_CreateLocationDataloads::COMPONENT_DATALOAD_CREATELOCATION];
                $ret[] = [GD_EM_Module_Processor_CreateLocationDataloads::class, GD_EM_Module_Processor_CreateLocationDataloads::COMPONENT_DATALOAD_TRIGGERTYPEAHEADSELECT_LOCATION];
                break;
        }

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_CREATELOCATION:
                // Add an extra componentPath to the dataload-source for the create-location block, saying to also load the data block
                $component_path_manager = ComponentPathManagerFacade::getInstance();
                $subcomponent_propagation_path = $component_path_manager->getPropagationCurrentPath();
                $subcomponent_propagation_path[] = $component;
                $subcomponent_propagation_path[] = [GD_EM_Module_Processor_CreateLocationDataloads::class, GD_EM_Module_Processor_CreateLocationDataloads::COMPONENT_DATALOAD_TRIGGERTYPEAHEADSELECT_LOCATION];
                $this->mergeProp(
                    [
                        [GD_EM_Module_Processor_CreateLocationDataloads::class, GD_EM_Module_Processor_CreateLocationDataloads::COMPONENT_DATALOAD_CREATELOCATION]
                    ],
                    $props,
                    'dataload-source-add-componentPaths',
                    array(
                        $subcomponent_propagation_path,
                    )
                );
                break;
        }

        parent::initModelProps($component, $props);
    }
}



