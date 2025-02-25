<?php

abstract class PoP_Module_Processor_UpdateProfileDataloadsBase extends PoP_Module_Processor_UpdateUserDataloadsBase
{
    protected function getFeedbackMessageComponent(\PoP\ComponentModel\Component\Component $component)
    {
        return [PoP_Module_Processor_ProfileFeedbackMessages::class, PoP_Module_Processor_ProfileFeedbackMessages::COMPONENT_FEEDBACKMESSAGE_UPDATEPROFILE];
    }

    public function getJsmethods(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getJsmethods($component, $props);

        $this->addJsmethod($ret, 'destroyPageOnUserLoggedOut');
        $this->addJsmethod($ret, 'refetchBlockOnUserLoggedIn');

        return $ret;
    }
}
