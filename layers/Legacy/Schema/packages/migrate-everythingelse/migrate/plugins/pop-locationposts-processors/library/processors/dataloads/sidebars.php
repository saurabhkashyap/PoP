<?php
use PoPCMSSchema\CustomPosts\TypeHelpers\CustomPostUnionTypeHelpers;
use PoPCMSSchema\QueriedObject\ComponentProcessors\QueriedDBObjectComponentProcessorTrait;

class PoP_LocationPosts_Module_Processor_CustomSidebarDataloads extends PoP_Module_Processor_DataloadsBase
{
    use QueriedDBObjectComponentProcessorTrait;

    public final const MODULE_DATALOAD_SINGLE_LOCATIONPOST_SIDEBAR = 'dataload-single-locationpost-sidebar';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_SINGLE_LOCATIONPOST_SIDEBAR],
        );
    }

    protected function getInnerSubmodules(array $componentVariation): array
    {
        $ret = parent::getInnerSubmodules($componentVariation);

        $orientation = \PoP\Root\App::applyFilters(POP_HOOK_BLOCKSIDEBARS_ORIENTATION, 'vertical');
        $vertical = ($orientation == 'vertical');
        $inners = array(
            self::MODULE_DATALOAD_SINGLE_LOCATIONPOST_SIDEBAR => $vertical ?
                [GD_SP_EM_Module_Processor_CustomVerticalSingleSidebars::class, GD_SP_EM_Module_Processor_CustomVerticalSingleSidebars::MODULE_VERTICALSIDEBAR_SINGLE_LOCATIONPOST] :
                [GD_Custom_EM_Module_Processor_CustomPostLayoutSidebars::class, GD_Custom_EM_Module_Processor_CustomPostLayoutSidebars::MODULE_LAYOUT_POSTSIDEBAR_HORIZONTAL_LOCATIONPOST],
        );

        if ($inner = $inners[$componentVariation[1]] ?? null) {
            $ret[] = $inner;
        }

        return $ret;
    }

    public function getObjectIDOrIDs(array $componentVariation, array &$props, &$data_properties): string | int | array
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_SINGLE_LOCATIONPOST_SIDEBAR:
                return $this->getQueriedDBObjectID($componentVariation, $props, $data_properties);
        }

        return parent::getObjectIDOrIDs($componentVariation, $props, $data_properties);
    }

    // public function getNature(array $componentVariation)
    // {
    //     switch ($componentVariation[1]) {
    //         case self::MODULE_DATALOAD_SINGLE_LOCATIONPOST_SIDEBAR:
    //             return CustomPostRequestNature::CUSTOMPOST;
    //     }

    //     return parent::getNature($componentVariation);
    // }

    public function getRelationalTypeResolver(array $componentVariation): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_SINGLE_LOCATIONPOST_SIDEBAR:
                return CustomPostUnionTypeHelpers::getCustomPostUnionOrTargetObjectTypeResolver();
        }

        return parent::getRelationalTypeResolver($componentVariation);
    }
}



