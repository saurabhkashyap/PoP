<?php
class PoP_UserCommunities_Installation
{
    public function __construct()
    {
        \PoP\Root\App::getHookManager()->addAction('PoP:system-build', array($this, 'installRoles'));
    }

    public function installRoles()
    {
        $cmsuserrolesapi = \PoPSchema\UserRoles\FunctionAPIFactory::getInstance();
        $cmsuserrolesapi->addRole(GD_URE_ROLE_COMMUNITY, 'GD Community', array());
    }
}

/**
 * Initialization
 */
new PoP_UserCommunities_Installation();
