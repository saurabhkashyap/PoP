<?php
use PoP\Engine\ComponentProcessors\ObjectIDsFromURLParamComponentProcessorTrait;
use PoPCMSSchema\Locations\TypeResolvers\ObjectType\LocationObjectTypeResolver;

class PoP_Module_Processor_LocationsMapDataloads extends PoP_Module_Processor_DataloadsBase
{
    use ObjectIDsFromURLParamComponentProcessorTrait;

    public final const COMPONENT_DATALOAD_LOCATIONSMAP = 'dataload-locationsmap';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_DATALOAD_LOCATIONSMAP],
        );
    }

    public function getRelevantRoute(array $component, array &$props): ?string
    {
        return match($component[1]) {
            self::COMPONENT_DATALOAD_LOCATIONSMAP => POP_LOCATIONS_ROUTE_LOCATIONSMAP,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    protected function getInnerSubcomponents(array $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_LOCATIONSMAP:
                // $ret[] = [PoP_Locations_Module_Processor_CustomScrolls::class, PoP_Locations_Module_Processor_CustomScrolls::COMPONENT_SCROLL_STATICIMAGE];
                // $ret[] = [PoP_Module_Processor_MapDivs::class, PoP_Module_Processor_MapDivs::COMPONENT_MAP_DIV];
                $ret[] = [PoP_Module_Processor_MapDivs::class, PoP_Module_Processor_MapDivs::COMPONENT_MAPSTATICIMAGE_DIV];
                $ret[] = [PoP_Locations_Module_Processor_CustomScrollMaps::class, PoP_Locations_Module_Processor_CustomScrollMaps::COMPONENT_SCROLL_LOCATIONS_MAP];
                // $ret[] = [PoP_Module_Processor_MapDrawMarkerScripts::class, PoP_Module_Processor_MapDrawMarkerScripts::COMPONENT_MAP_SCRIPT_DRAWMARKERS];
                $ret[] = [PoP_Module_Processor_MapDrawMarkerScripts::class, PoP_Module_Processor_MapDrawMarkerScripts::COMPONENT_MAPSTATICIMAGE_SCRIPT_DRAWMARKERS];
                $ret[] = [PoP_Module_Processor_MapResetMarkerScripts::class, PoP_Module_Processor_MapResetMarkerScripts::COMPONENT_MAP_SCRIPT_RESETMARKERS];
                break;
        }

        return $ret;
    }

    public function getObjectIDOrIDs(array $component, array &$props, &$data_properties): string | int | array
    {
        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_LOCATIONSMAP:
                return $this->getObjectIDsFromURLParam($component, $props, $data_properties);
        }
        return parent::getObjectIDOrIDs($component, $props, $data_properties);
    }

    protected function getObjectIDsParamName(array $component, array &$props, &$data_properties)
    {
        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_LOCATIONSMAP:
                return POP_INPUTNAME_LOCATIONID;
        }
        return null;
    }

    public function getRelationalTypeResolver(array $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_LOCATIONSMAP:
                return $this->instanceManager->getInstance(LocationObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($component);
    }
}



