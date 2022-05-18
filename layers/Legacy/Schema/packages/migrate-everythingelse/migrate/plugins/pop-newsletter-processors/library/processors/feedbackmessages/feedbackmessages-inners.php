<?php

class PoP_Newsletter_Module_Processor_FeedbackMessageInners extends PoP_Module_Processor_ActionExecutionFeedbackMessageInnersBase
{
    public final const MODULE_FEEDBACKMESSAGEINNER_NEWSLETTER = 'feedbackmessageinner-newsletter';
    public final const MODULE_FEEDBACKMESSAGEINNER_NEWSLETTERUNSUBSCRIPTION = 'feedbackmessageinner-newsletterunsubscription';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FEEDBACKMESSAGEINNER_NEWSLETTER],
            [self::class, self::MODULE_FEEDBACKMESSAGEINNER_NEWSLETTERUNSUBSCRIPTION],
        );
    }

    public function getLayoutSubmodules(array $componentVariation)
    {
        $ret = parent::getLayoutSubmodules($componentVariation);

        $layouts = array(
            self::MODULE_FEEDBACKMESSAGEINNER_NEWSLETTER => [PoP_Newsletter_Module_Processor_FeedbackMessageAlertLayouts::class, PoP_Newsletter_Module_Processor_FeedbackMessageAlertLayouts::MODULE_LAYOUT_FEEDBACKMESSAGEALERT_NEWSLETTER],
            self::MODULE_FEEDBACKMESSAGEINNER_NEWSLETTERUNSUBSCRIPTION => [PoP_Newsletter_Module_Processor_FeedbackMessageAlertLayouts::class, PoP_Newsletter_Module_Processor_FeedbackMessageAlertLayouts::MODULE_LAYOUT_FEEDBACKMESSAGEALERT_NEWSLETTERUNSUBSCRIPTION],
        );

        if ($layout = $layouts[$componentVariation[1]] ?? null) {
            $ret[] = $layout;
        }

        return $ret;
    }
}



