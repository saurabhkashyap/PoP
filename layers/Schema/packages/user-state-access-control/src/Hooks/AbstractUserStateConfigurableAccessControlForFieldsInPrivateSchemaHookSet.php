<?php

declare(strict_types=1);

namespace PoPSchema\UserStateAccessControl\Hooks;

use PoP\AccessControl\Hooks\AbstractConfigurableAccessControlForFieldsInPrivateSchemaHookSet;
use PoP\ComponentModel\State\ApplicationState;
use PoPSchema\UserStateAccessControl\Services\AccessControlGroups;

abstract class AbstractUserStateConfigurableAccessControlForFieldsInPrivateSchemaHookSet extends AbstractConfigurableAccessControlForFieldsInPrivateSchemaHookSet
{
    /**
     * Configuration entries
     */
    protected function getConfigurationEntries(): array
    {
        return $this->getAccessControlManager()->getEntriesForFields(AccessControlGroups::STATE);
    }

    protected function removeFieldNameBasedOnMatchingEntryValue($entryValue = null): bool
    {
        // Obtain the user state: logged in or not
        $isUserLoggedIn = \PoP\Root\App::getState('is-user-logged-in');
        // Let the implementation class decide if to remove the field or not
        return $this->removeFieldNameBasedOnUserState((string)$entryValue, $isUserLoggedIn);
    }

    abstract protected function removeFieldNameBasedOnUserState(string $entryValue, bool $isUserLoggedIn): bool;
}
