<?php

declare(strict_types=1);

namespace PoPSchema\PostCategoryMutations\SchemaHooks;

use PoPSchema\Categories\TypeResolvers\ObjectType\CategoryObjectTypeResolverInterface;
use PoPSchema\CustomPostCategoryMutations\Hooks\AbstractCustomPostMutationResolverHookSet;
use PoPSchema\CustomPostCategoryMutations\TypeAPIs\CustomPostCategoryTypeMutationAPIInterface;
use PoPSchema\PostCategories\TypeResolvers\ObjectType\PostCategoryObjectTypeResolver;
use PoPSchema\PostCategoryMutations\Facades\PostCategoryTypeMutationAPIFacade;
use PoPSchema\PostMutations\SchemaHooks\PostMutationResolverHookSetTrait;
use PoPSchema\Posts\TypeAPIs\PostTypeAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

class PostMutationResolverHookSet extends AbstractCustomPostMutationResolverHookSet
{
    use PostMutationResolverHookSetTrait;

    protected ?PostCategoryObjectTypeResolver $postCategoryObjectTypeResolver = null;
    protected ?PostTypeAPIInterface $postTypeAPI = null;

    public function setPostCategoryObjectTypeResolver(PostCategoryObjectTypeResolver $postCategoryObjectTypeResolver): void
    {
        $this->postCategoryObjectTypeResolver = $postCategoryObjectTypeResolver;
    }
    protected function getPostCategoryObjectTypeResolver(): PostCategoryObjectTypeResolver
    {
        return $this->postCategoryObjectTypeResolver ??= $this->getInstanceManager()->getInstance(PostCategoryObjectTypeResolver::class);
    }
    public function setPostTypeAPI(PostTypeAPIInterface $postTypeAPI): void
    {
        $this->postTypeAPI = $postTypeAPI;
    }
    protected function getPostTypeAPI(): PostTypeAPIInterface
    {
        return $this->postTypeAPI ??= $this->getInstanceManager()->getInstance(PostTypeAPIInterface::class);
    }

    //#[Required]
    final public function autowirePostMutationResolverHookSet(
        PostCategoryObjectTypeResolver $postCategoryObjectTypeResolver,
        PostTypeAPIInterface $postTypeAPI,
    ): void {
        $this->postCategoryObjectTypeResolver = $postCategoryObjectTypeResolver;
        $this->postTypeAPI = $postTypeAPI;
    }

    protected function getCustomPostType(): string
    {
        return $this->getPostTypeAPI()->getPostCustomPostType();
    }

    protected function getCategoryTypeResolver(): CategoryObjectTypeResolverInterface
    {
        return $this->getPostCategoryObjectTypeResolver();
    }

    protected function getCustomPostCategoryTypeMutationAPI(): CustomPostCategoryTypeMutationAPIInterface
    {
        return PostCategoryTypeMutationAPIFacade::getInstance();
    }
}
