<?php

declare(strict_types=1);

namespace PoPSchema\Users\TypeAPIs;

use PoP\Engine\CMS\CMSHelperServiceInterface;
use PoP\Hooks\HooksAPIInterface;
use PoPSchema\Users\TypeAPIs\UserTypeAPIInterface;

abstract class AbstractUserTypeAPI implements UserTypeAPIInterface
{
    public function __construct(
        protected HooksAPIInterface $hooksAPI,
        protected CMSHelperServiceInterface $CMSHelperService,
    ) {
    }

    public function getUserURLPath(string | int | object $userObjectOrID): ?string
    {
        $userURL = $this->getUserURL($userObjectOrID);
        if ($userURL === null) {
            return null;
        }

        return $this->CMSHelperService->getURLPath($userURL);
    }
}
