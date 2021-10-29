<?php

declare(strict_types=1);

namespace PoPSchema\PostsWP\ConditionalOnContext\AddPostTypeToCustomPostUnionTypes\Overrides\SchemaServices\ObjectTypeResolverPickers;

use PoPSchema\CustomPostsWP\ObjectTypeResolverPickers\CustomPostObjectTypeResolverPickerInterface;
use PoPSchema\CustomPostsWP\ObjectTypeResolverPickers\NoCastCustomPostTypeResolverPickerTrait;
use PoPSchema\Posts\ConditionalOnContext\AddPostTypeToCustomPostUnionTypes\SchemaServices\ObjectTypeResolverPickers\PostCustomPostObjectTypeResolverPicker as UpstreamPostCustomPostObjectTypeResolverPicker;

class PostCustomPostObjectTypeResolverPicker extends UpstreamPostCustomPostObjectTypeResolverPicker implements CustomPostObjectTypeResolverPickerInterface
{
    use NoCastCustomPostTypeResolverPickerTrait;

    public function getCustomPostType(): string
    {
        return $this->getPostTypeAPI()->getPostCustomPostType();
    }
}
