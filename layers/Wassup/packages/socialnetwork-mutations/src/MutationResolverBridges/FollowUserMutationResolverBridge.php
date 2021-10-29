<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\FollowUserMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class FollowUserMutationResolverBridge extends AbstractUserUpdateUserMetaValueMutationResolverBridge
{
    protected ?FollowUserMutationResolver $followUserMutationResolver = null;

    public function setFollowUserMutationResolver(FollowUserMutationResolver $followUserMutationResolver): void
    {
        $this->followUserMutationResolver = $followUserMutationResolver;
    }
    protected function getFollowUserMutationResolver(): FollowUserMutationResolver
    {
        return $this->followUserMutationResolver ??= $this->getInstanceManager()->getInstance(FollowUserMutationResolver::class);
    }

    //#[Required]
    final public function autowireFollowUserMutationResolverBridge(
        FollowUserMutationResolver $followUserMutationResolver,
    ): void {
        $this->followUserMutationResolver = $followUserMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getFollowUserMutationResolver();
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        return sprintf(
            $this->getTranslationAPI()->__('You are now following <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $this->getUserTypeAPI()->getUserDisplayName($result_id)
        );
    }
}
