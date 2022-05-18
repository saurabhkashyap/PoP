<?php

class PoP_Volunteering_Module_Processor_FeedbackMessages extends PoP_Module_Processor_FeedbackMessagesBase
{
    public final const MODULE_FEEDBACKMESSAGE_VOLUNTEER = 'feedbackmessage-volunteer';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FEEDBACKMESSAGE_VOLUNTEER],
        );
    }

    public function getInnerSubmodule(array $componentVariation)
    {
        $inners = array(
            self::MODULE_FEEDBACKMESSAGE_VOLUNTEER => [PoP_Volunteering_Module_Processor_FeedbackMessageInners::class, PoP_Volunteering_Module_Processor_FeedbackMessageInners::MODULE_FEEDBACKMESSAGEINNER_VOLUNTEER],
        );

        if ($inner = $inners[$componentVariation[1]] ?? null) {
            return $inner;
        }

        return parent::getInnerSubmodule($componentVariation);
    }
}



