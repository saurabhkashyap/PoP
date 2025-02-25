<?php

class PoP_CommonUserRoles_Module_Processor_UserCheckpointMessageInners extends PoP_Module_Processor_CheckpointMessageInnersBase
{
    public final const COMPONENT_CHECKPOINTMESSAGEINNER_PROFILEORGANIZATION = 'checkpointmessageinner-profileorganization';
    public final const COMPONENT_CHECKPOINTMESSAGEINNER_PROFILEINDIVIDUAL = 'checkpointmessageinner-profileindividual';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_CHECKPOINTMESSAGEINNER_PROFILEORGANIZATION,
            self::COMPONENT_CHECKPOINTMESSAGEINNER_PROFILEINDIVIDUAL,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getLayoutSubcomponents($component);

        $layouts = array(
            self::COMPONENT_CHECKPOINTMESSAGEINNER_PROFILEORGANIZATION => [PoP_CommonUserRoles_Module_Processor_UserCheckpointMessageAlertLayouts::class, PoP_CommonUserRoles_Module_Processor_UserCheckpointMessageAlertLayouts::COMPONENT_LAYOUT_CHECKPOINTMESSAGEALERT_PROFILEORGANIZATION],
            self::COMPONENT_CHECKPOINTMESSAGEINNER_PROFILEINDIVIDUAL => [PoP_CommonUserRoles_Module_Processor_UserCheckpointMessageAlertLayouts::class, PoP_CommonUserRoles_Module_Processor_UserCheckpointMessageAlertLayouts::COMPONENT_LAYOUT_CHECKPOINTMESSAGEALERT_PROFILEINDIVIDUAL],
        );

        if ($layout = $layouts[$component->name] ?? null) {
            $ret[] = $layout;
        }

        return $ret;
    }
}



