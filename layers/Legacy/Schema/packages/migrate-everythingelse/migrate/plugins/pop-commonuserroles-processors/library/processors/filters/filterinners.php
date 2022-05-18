<?php

class PoP_CommonUserRoles_Module_Processor_CustomFilterInners extends PoP_Module_Processor_FilterInnersBase
{
    public final const MODULE_FILTERINPUTCONTAINER_INDIVIDUALS = 'filterinputcontainer-individuals';
    public final const MODULE_FILTERINPUTCONTAINER_ORGANIZATIONS = 'filterinputcontainer-organizations';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FILTERINPUTCONTAINER_INDIVIDUALS],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_ORGANIZATIONS],
        );
    }

    protected function getInputSubmodules(array $componentVariation)
    {
        $ret = parent::getInputSubmodules($componentVariation);

        $inputmodules = [
            self::MODULE_FILTERINPUTCONTAINER_INDIVIDUALS => [
                [PoP_Module_Processor_FormInputGroups::class, PoP_Module_Processor_FormInputGroups::MODULE_FILTERINPUTGROUP_NAME],
                [GD_URE_Module_Processor_FormGroups::class, GD_URE_Module_Processor_FormGroups::MODULE_URE_FILTERCOMPONENTGROUP_SELECTABLETYPEAHEAD_COMMUNITIES_USER],
                [PoP_Module_Processor_FormInputGroups::class, PoP_Module_Processor_FormInputGroups::MODULE_FILTERINPUTGROUP_ORDERUSER],
            ],
            self::MODULE_FILTERINPUTCONTAINER_ORGANIZATIONS => [
                [PoP_Module_Processor_FormInputGroups::class, PoP_Module_Processor_FormInputGroups::MODULE_FILTERINPUTGROUP_NAME],
                [GD_URE_Module_Processor_FormGroups::class, GD_URE_Module_Processor_FormGroups::MODULE_URE_FILTERCOMPONENTGROUP_SELECTABLETYPEAHEAD_COMMUNITIES_USER],
                [PoP_Module_Processor_FormInputGroups::class, PoP_Module_Processor_FormInputGroups::MODULE_FILTERINPUTGROUP_ORDERUSER],
            ],
        ];
        if ($modules = \PoP\Root\App::applyFilters(
            'CommonUserRoles:FilterInnerComponentProcessor:inputmodules',
            $inputmodules[$componentVariation[1]],
            $componentVariation
        )) {
            $ret = array_merge(
                $ret,
                $modules
            );
        }
        return $ret;
    }

    // public function getFilter(array $componentVariation)
    // {
    //     $filters = array(
    //         self::MODULE_FILTERINPUTCONTAINER_INDIVIDUALS => POP_FILTER_INDIVIDUALS,
    //         self::MODULE_FILTERINPUTCONTAINER_ORGANIZATIONS => POP_FILTER_ORGANIZATIONS,
    //     );
    //     if ($filter = $filters[$componentVariation[1]] ?? null) {
    //         return $filter;
    //     }

    //     return parent::getFilter($componentVariation);
    // }
}



