<?php

declare(strict_types=1);

namespace PoPSchema\Menus\TypeResolvers\ObjectType;

use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;
use PoPSchema\Menus\ObjectModels\MenuItem;
use PoPSchema\Menus\RelationalTypeDataLoaders\ObjectType\MenuItemTypeDataLoader;

class MenuItemTypeResolver extends AbstractObjectTypeResolver
{
    public function getTypeName(): string
    {
        return 'MenuItem';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('Items (links, pages, etc) added to a menu', 'menus');
    }

    public function getID(object $resultItem): string | int | null
    {
        /** @var MenuItem */
        $menuItem = $resultItem;
        return $menuItem->id;
    }

    public function getRelationalTypeDataLoaderClass(): string
    {
        return MenuItemTypeDataLoader::class;
    }
}
