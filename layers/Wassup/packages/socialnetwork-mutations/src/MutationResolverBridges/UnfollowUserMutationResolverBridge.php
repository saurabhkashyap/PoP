<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\UnfollowUserMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class UnfollowUserMutationResolverBridge extends AbstractUserUpdateUserMetaValueMutationResolverBridge
{
    protected UnfollowUserMutationResolver $unfollowUserMutationResolver;

    #[Required]
    final public function autowireUnfollowUserMutationResolverBridge(
        UnfollowUserMutationResolver $unfollowUserMutationResolver,
    ): void {
        $this->unfollowUserMutationResolver = $unfollowUserMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getUnfollowUserMutationResolver();
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        return sprintf(
            $this->getTranslationAPI()->__('You have stopped following <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $this->getUserTypeAPI()->getUserDisplayName($result_id)
        );
    }
}
