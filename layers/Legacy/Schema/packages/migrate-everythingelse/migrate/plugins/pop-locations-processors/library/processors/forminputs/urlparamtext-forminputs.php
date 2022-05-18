<?php

class GD_EM_Module_Processor_UrlParamTextFormInputs extends PoP_Module_Processor_UrlParamTextFormInputsBase
{
    public final const MODULE_FORMINPUT_URLPARAMTEXT_LOCATIONID = 'forminput-urlparam-locationid';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMINPUT_URLPARAMTEXT_LOCATIONID],
        );
    }

    public function getName(array $componentVariation): string
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_URLPARAMTEXT_LOCATIONID:
                return POP_INPUTNAME_LOCATIONID;
        }

        return parent::getName($componentVariation);
    }
}



