<?php

class GD_UserLogin_Module_Processor_UserCheckpointMessages extends PoP_Module_Processor_FeedbackMessagesBase
{
    public final const COMPONENT_CHECKPOINTMESSAGE_NOTLOGGEDIN = 'checkpointmessage-notloggedin';
    public final const COMPONENT_CHECKPOINTMESSAGE_LOGGEDIN = 'checkpointmessage-loggedin';
    public final const COMPONENT_CHECKPOINTMESSAGE_LOGGEDINCANEDIT = 'checkpointmessage-loggedincanedit';
    public final const COMPONENT_CHECKPOINTMESSAGE_LOGGEDINISADMIN = 'checkpointmessage-loggedinisadmin';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_CHECKPOINTMESSAGE_NOTLOGGEDIN,
            self::COMPONENT_CHECKPOINTMESSAGE_LOGGEDIN,
            self::COMPONENT_CHECKPOINTMESSAGE_LOGGEDINCANEDIT,
            self::COMPONENT_CHECKPOINTMESSAGE_LOGGEDINISADMIN,
        );
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inners = array(
            self::COMPONENT_CHECKPOINTMESSAGE_NOTLOGGEDIN => [GD_UserLogin_Module_Processor_UserCheckpointMessageInners::class, GD_UserLogin_Module_Processor_UserCheckpointMessageInners::COMPONENT_CHECKPOINTMESSAGEINNER_NOTLOGGEDIN],
            self::COMPONENT_CHECKPOINTMESSAGE_LOGGEDIN => [GD_UserLogin_Module_Processor_UserCheckpointMessageInners::class, GD_UserLogin_Module_Processor_UserCheckpointMessageInners::COMPONENT_CHECKPOINTMESSAGEINNER_LOGGEDIN],
            self::COMPONENT_CHECKPOINTMESSAGE_LOGGEDINCANEDIT => [GD_UserLogin_Module_Processor_UserCheckpointMessageInners::class, GD_UserLogin_Module_Processor_UserCheckpointMessageInners::COMPONENT_CHECKPOINTMESSAGEINNER_LOGGEDINCANEDIT],
            self::COMPONENT_CHECKPOINTMESSAGE_LOGGEDINISADMIN => [GD_UserLogin_Module_Processor_UserCheckpointMessageInners::class, GD_UserLogin_Module_Processor_UserCheckpointMessageInners::COMPONENT_CHECKPOINTMESSAGEINNER_LOGGEDINISADMIN],
        );

        if ($inner = $inners[$component->name] ?? null) {
            return $inner;
        }

        return parent::getInnerSubcomponent($component);
    }
}



