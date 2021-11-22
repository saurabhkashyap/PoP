<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\TypeResolvers\InputObjectType;

class CustomPostByInputObjectTypeResolver extends AbstractRootCustomPostByInputObjectTypeResolver
{
    public function getTypeName(): string
    {
        return 'CustomPostByInput';
    }
}