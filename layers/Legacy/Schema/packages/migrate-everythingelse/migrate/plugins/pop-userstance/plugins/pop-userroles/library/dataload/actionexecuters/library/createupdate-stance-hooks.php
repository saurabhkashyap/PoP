<?php
use PoP\ComponentModel\State\ApplicationState;

class UserStance_DataLoad_CreateUpdateStanceHooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'GD_CreateUpdate_Stance:createAdditionals',
            $this->createAdditionals(...)
        );
    }

    public function createAdditionals($post_id)
    {

        // Redundancy on who has created the Stance: an individual or an organization
        // This way we can show the slider in the Homepage "Latest thoughts about TPP" and split them into "By people" / "By organizations"
        // This works because the Stance has only 1 author
        \PoPCMSSchema\CustomPostMeta\Utils::addCustomPostMeta($post_id, GD_URE_METAKEY_POST_AUTHORROLE, gdUreGetuserrole(\PoP\Root\App::getState('current-user-id')), true);
    }
}

/**
 * Initialize
 */
new UserStance_DataLoad_CreateUpdateStanceHooks();
