<?php

declare(strict_types=1);

namespace PoPSitesWassup\PostMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\PostMutations\MutationResolvers\CreatePostMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class CreatePostMutationResolverBridge extends AbstractCreateUpdatePostMutationResolverBridge
{
    protected ?CreatePostMutationResolver $createPostMutationResolver = null;

    public function setCreatePostMutationResolver(CreatePostMutationResolver $createPostMutationResolver): void
    {
        $this->createPostMutationResolver = $createPostMutationResolver;
    }
    protected function getCreatePostMutationResolver(): CreatePostMutationResolver
    {
        return $this->createPostMutationResolver ??= $this->instanceManager->getInstance(CreatePostMutationResolver::class);
    }

    //#[Required]
    final public function autowireCreatePostMutationResolverBridge(
        CreatePostMutationResolver $createPostMutationResolver,
    ): void {
        $this->createPostMutationResolver = $createPostMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getCreatePostMutationResolver();
    }

    protected function isUpdate(): bool
    {
        return false;
    }
}
