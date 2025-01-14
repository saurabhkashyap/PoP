<?php

declare(strict_types=1);

namespace PoPCMSSchema\CustomPostMutations\TypeResolvers\InputObjectType;

class CustomPostUpdateFilterInputObjectTypeResolver extends AbstractCreateOrUpdateCustomPostFilterInputObjectTypeResolver implements UpdateCustomPostFilterInputObjectTypeResolverInterface
{
    public function getTypeName(): string
    {
        return 'CustomPostUpdateFilterInput';
    }

    protected function addCustomPostInputField(): bool
    {
        return false;
    }
}
