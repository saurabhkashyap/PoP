<?php

declare(strict_types=1);

namespace PoPSitesWassup\UserStateMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSchema\UserStateMutations\MutationResolvers\LogoutMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class LogoutMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    protected ?LogoutMutationResolver $logoutMutationResolver = null;

    public function setLogoutMutationResolver(LogoutMutationResolver $logoutMutationResolver): void
    {
        $this->logoutMutationResolver = $logoutMutationResolver;
    }
    protected function getLogoutMutationResolver(): LogoutMutationResolver
    {
        return $this->logoutMutationResolver ??= $this->getInstanceManager()->getInstance(LogoutMutationResolver::class);
    }

    //#[Required]
    final public function autowireLogoutMutationResolverBridge(
        LogoutMutationResolver $logoutMutationResolver,
    ): void {
        $this->logoutMutationResolver = $logoutMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getLogoutMutationResolver();
    }

    public function getFormData(): array
    {
        return [];
    }
}
