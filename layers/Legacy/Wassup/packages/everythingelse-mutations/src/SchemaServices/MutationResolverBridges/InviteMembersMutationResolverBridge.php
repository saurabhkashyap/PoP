<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\InviteMembersMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class InviteMembersMutationResolverBridge extends AbstractEmailInviteMutationResolverBridge
{
    protected ?InviteMembersMutationResolver $inviteMembersMutationResolver = null;
    
    public function setInviteMembersMutationResolver(InviteMembersMutationResolver $inviteMembersMutationResolver): void
    {
        $this->inviteMembersMutationResolver = $inviteMembersMutationResolver;
    }
    protected function getInviteMembersMutationResolver(): InviteMembersMutationResolver
    {
        return $this->inviteMembersMutationResolver ??= $this->getInstanceManager()->getInstance(InviteMembersMutationResolver::class);
    }

    //#[Required]
    final public function autowireInviteMembersMutationResolverBridge(
        InviteMembersMutationResolver $inviteMembersMutationResolver,
    ): void {
        $this->inviteMembersMutationResolver = $inviteMembersMutationResolver;
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getInviteMembersMutationResolver();
    }
}
