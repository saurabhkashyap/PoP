<?php

declare(strict_types=1);

namespace PoPSchema\Posts\ObjectTypeResolverPickers;

use PoP\ComponentModel\ObjectTypeResolverPickers\AbstractObjectTypeResolverPicker;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPSchema\Posts\TypeAPIs\PostTypeAPIInterface;
use PoPSchema\Posts\TypeResolvers\ObjectType\PostObjectTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractPostObjectTypeResolverPicker extends AbstractObjectTypeResolverPicker
{
    protected PostObjectTypeResolver $postObjectTypeResolver;
    protected PostTypeAPIInterface $postTypeAPI;

    #[Required]
    final public function autowireAbstractPostObjectTypeResolverPicker(PostObjectTypeResolver $postObjectTypeResolver, PostTypeAPIInterface $postTypeAPI): void
    {
        $this->postObjectTypeResolver = $postObjectTypeResolver;
        $this->postTypeAPI = $postTypeAPI;
    }

    public function getObjectTypeResolver(): ObjectTypeResolverInterface
    {
        return $this->getPostObjectTypeResolver();
    }

    public function isInstanceOfType(object $object): bool
    {
        return $this->getPostTypeAPI()->isInstanceOfPostType($object);
    }

    public function isIDOfType(string | int $objectID): bool
    {
        return $this->getPostTypeAPI()->postExists($objectID);
    }
}
