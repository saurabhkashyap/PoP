<?php

use PoP\ComponentModel\Checkpoints\AbstractCheckpoint;
use PoP\Root\Feedback\FeedbackItemResolution;

class GD_URE_Dataload_UserCheckpoint extends AbstractCheckpoint
{
    public final const CHECKPOINT_LOGGEDINUSER_ISPROFILEORGANIZATION = 'checkpoint-loggedinuser-isprofileorganization';
    public final const CHECKPOINT_LOGGEDINUSER_ISPROFILEINDIVIDUAL = 'checkpoint-loggedinuser-isprofileindividual';

    /**
     * @todo Migrate to not using $checkpoint
     */
    public function validateCheckpoint(): ?FeedbackItemResolution
    {
        $current_user_id = \PoP\Root\App::getState('current-user-id');
        switch ($checkpoint[1]) {
            case self::CHECKPOINT_LOGGEDINUSER_ISPROFILEORGANIZATION:
                if (!gdUreIsOrganization($current_user_id)) {
                    return new FeedbackItemResolution('profilenotorganization', 'profilenotorganization');
                }
                break;

            case self::CHECKPOINT_LOGGEDINUSER_ISPROFILEINDIVIDUAL:
                if (!gdUreIsIndividual($current_user_id)) {
                    return new FeedbackItemResolution('profilenotindividual', 'profilenotindividual');
                }
                break;
        }

        return parent::validateCheckpoint();
    }
}

