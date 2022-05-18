<?php

class GD_URE_Module_Processor_UserSelectableTypeaheadTriggerFormComponents extends PoP_Module_Processor_UserTriggerLayoutFormComponentValuesBase
{
    public final const MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADTRIGGER_USERCOMMUNITIES = 'formcomponent-selectabletypeaheadtrigger-usercommunities';
    public final const MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_COMMUNITIES = 'filtercomponent-selectabletypeaheadtrigger-communities';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADTRIGGER_USERCOMMUNITIES],
            [self::class, self::MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_COMMUNITIES],
        );
    }

    public function getTriggerSubmodule(array $componentVariation): ?array
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADTRIGGER_USERCOMMUNITIES:
            case self::MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_COMMUNITIES:
                $layouts = array(
                    self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADTRIGGER_USERCOMMUNITIES => [GD_URE_Module_Processor_UserSelectableTypeaheadAlertFormComponents::class, GD_URE_Module_Processor_UserSelectableTypeaheadAlertFormComponents::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_USERCOMMUNITIES],
                    self::MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_COMMUNITIES => [GD_URE_Module_Processor_UserSelectableTypeaheadAlertFormComponents::class, GD_URE_Module_Processor_UserSelectableTypeaheadAlertFormComponents::MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADALERT_COMMUNITIES],
                );
                return $layouts[$componentVariation[1]];
        }

        return parent::getTriggerSubmodule($componentVariation);
    }

    public function getDbobjectField(array $componentVariation): ?string
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADTRIGGER_USERCOMMUNITIES:
            case self::MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_COMMUNITIES:
                return 'communities';
        }

        return parent::getDbobjectField($componentVariation);
    }
}



