<?php

class PoP_UserAvatarProcessors_Module_Processor_UserFeedbackMessageAlertLayouts extends PoP_Module_Processor_FeedbackMessageAlertLayoutsBase
{
    public final const COMPONENT_LAYOUT_FEEDBACKMESSAGEALERT_USERAVATAR_UPDATE = 'layout-feedbackmessagealert-useravatar-update';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUT_FEEDBACKMESSAGEALERT_USERAVATAR_UPDATE,
        );
    }

    public function getLayoutSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $layouts = array(
            self::COMPONENT_LAYOUT_FEEDBACKMESSAGEALERT_USERAVATAR_UPDATE => [PoP_UserAvatarProcessors_Module_Processor_UserFeedbackMessageLayouts::class, PoP_UserAvatarProcessors_Module_Processor_UserFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_USERAVATAR_UPDATE],
        );

        if ($layout = $layouts[$component->name] ?? null) {
            return $layout;
        }

        return parent::getLayoutSubcomponent($component);
    }
}



