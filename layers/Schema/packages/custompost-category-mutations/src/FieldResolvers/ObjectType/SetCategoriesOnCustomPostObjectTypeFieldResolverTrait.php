<?php

declare(strict_types=1);

namespace PoPSchema\CustomPostCategoryMutations\FieldResolvers\ObjectType;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Translation\TranslationAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait SetCategoriesOnCustomPostObjectTypeFieldResolverTrait
{
    protected ?TranslationAPIInterface $translationAPI = null;

    public function setTranslationAPI(TranslationAPIInterface $translationAPI): void
    {
        $this->translationAPI = $translationAPI;
    }
    protected function getTranslationAPI(): TranslationAPIInterface
    {
        return $this->translationAPI ??= $this->getInstanceManager()->getInstance(TranslationAPIInterface::class);
    }

    //#[Required]
    public function autowireSetCategoriesOnCustomPostObjectTypeFieldResolverTrait(
        TranslationAPIInterface $translationAPI,
    ): void {
        $this->translationAPI = $translationAPI;
    }

    protected function getEntityName(): string
    {
        return $this->getTranslationAPI()->__('custom post', 'custompost-category-mutations');
    }
}
