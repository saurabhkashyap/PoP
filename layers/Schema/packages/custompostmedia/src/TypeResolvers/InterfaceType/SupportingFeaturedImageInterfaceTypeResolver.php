<?php

declare(strict_types=1);

namespace PoPSchema\CustomPostMedia\TypeResolvers\InterfaceType;

use PoP\ComponentModel\TypeResolvers\InterfaceType\AbstractInterfaceTypeResolver;

class SupportingFeaturedImageInterfaceTypeResolver extends AbstractInterfaceTypeResolver
{
    public function getTypeName(): string
    {
        return 'SupportingFeaturedImage';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('Fields concerning an entity\'s featured image', 'custompostmedia');
    }
}