<?php

class PoP_Module_Processor_FormGroups extends PoP_Module_Processor_FormGroupsBase
{
    public final const MODULE_SUBMITBUTTONFORMGROUP_SEARCH = 'submitbuttonformgroup-search';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_SUBMITBUTTONFORMGROUP_SEARCH],
        );
    }

    public function getFormcontrolClass(array $componentVariation)
    {
        $ret = parent::getFormcontrolClass($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_SUBMITBUTTONFORMGROUP_SEARCH:
                $ret .= ' col-sm-offset-2 col-sm-10';
                break;
        }

        return $ret;
    }

    public function getComponentSubmodule(array $componentVariation)
    {
        $components = array(
            self::MODULE_SUBMITBUTTONFORMGROUP_SEARCH => [PoP_Module_Processor_SubmitButtons::class, PoP_Module_Processor_SubmitButtons::MODULE_SUBMITBUTTON_SEARCH],
        );

        if ($component = $components[$componentVariation[1]] ?? null) {
            return $component;
        }

        return parent::getComponentSubmodule($componentVariation);
    }
}



