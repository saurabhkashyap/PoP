<?php

declare(strict_types=1);

namespace PoPSitesWassup\HighlightMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\HighlightMutations\MutationResolvers\UpdateHighlightMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class UpdateHighlightMutationResolverBridge extends AbstractCreateUpdateHighlightMutationResolverBridge
{
    protected ?UpdateHighlightMutationResolver $updateHighlightMutationResolver = null;

    public function setUpdateHighlightMutationResolver(UpdateHighlightMutationResolver $updateHighlightMutationResolver): void
    {
        $this->updateHighlightMutationResolver = $updateHighlightMutationResolver;
    }
    protected function getUpdateHighlightMutationResolver(): UpdateHighlightMutationResolver
    {
        return $this->updateHighlightMutationResolver ??= $this->instanceManager->getInstance(UpdateHighlightMutationResolver::class);
    }

    //#[Required]
    final public function autowireUpdateHighlightMutationResolverBridge(
        UpdateHighlightMutationResolver $updateHighlightMutationResolver,
    ): void {
        $this->updateHighlightMutationResolver = $updateHighlightMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getUpdateHighlightMutationResolver();
    }

    protected function isUpdate(): bool
    {
        return true;
    }
}
