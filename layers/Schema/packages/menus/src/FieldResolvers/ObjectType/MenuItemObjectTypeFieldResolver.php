<?php

declare(strict_types=1);

namespace PoPSchema\Menus\FieldResolvers\ObjectType;

use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\CMS\CMSHelperServiceInterface;
use PoP\Engine\TypeResolvers\ScalarType\IDScalarTypeResolver;
use PoP\Engine\TypeResolvers\ScalarType\StringScalarTypeResolver;
use PoPSchema\Menus\ObjectModels\MenuItem;
use PoPSchema\Menus\RuntimeRegistries\MenuItemRuntimeRegistryInterface;
use PoPSchema\Menus\TypeResolvers\ObjectType\MenuItemObjectTypeResolver;
use PoPSchema\SchemaCommons\TypeResolvers\ScalarType\URLScalarTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class MenuItemObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    protected ?MenuItemRuntimeRegistryInterface $menuItemRuntimeRegistry = null;
    protected ?CMSHelperServiceInterface $cmsHelperService = null;
    protected ?URLScalarTypeResolver $urlScalarTypeResolver = null;
    protected ?IDScalarTypeResolver $idScalarTypeResolver = null;
    protected ?StringScalarTypeResolver $stringScalarTypeResolver = null;
    protected ?MenuItemObjectTypeResolver $menuItemObjectTypeResolver = null;

    public function setMenuItemRuntimeRegistry(MenuItemRuntimeRegistryInterface $menuItemRuntimeRegistry): void
    {
        $this->menuItemRuntimeRegistry = $menuItemRuntimeRegistry;
    }
    protected function getMenuItemRuntimeRegistry(): MenuItemRuntimeRegistryInterface
    {
        return $this->menuItemRuntimeRegistry ??= $this->getInstanceManager()->getInstance(MenuItemRuntimeRegistryInterface::class);
    }
    public function setCMSHelperService(CMSHelperServiceInterface $cmsHelperService): void
    {
        $this->cmsHelperService = $cmsHelperService;
    }
    protected function getCMSHelperService(): CMSHelperServiceInterface
    {
        return $this->cmsHelperService ??= $this->getInstanceManager()->getInstance(CMSHelperServiceInterface::class);
    }
    public function setURLScalarTypeResolver(URLScalarTypeResolver $urlScalarTypeResolver): void
    {
        $this->urlScalarTypeResolver = $urlScalarTypeResolver;
    }
    protected function getURLScalarTypeResolver(): URLScalarTypeResolver
    {
        return $this->urlScalarTypeResolver ??= $this->getInstanceManager()->getInstance(URLScalarTypeResolver::class);
    }
    public function setIDScalarTypeResolver(IDScalarTypeResolver $idScalarTypeResolver): void
    {
        $this->idScalarTypeResolver = $idScalarTypeResolver;
    }
    protected function getIDScalarTypeResolver(): IDScalarTypeResolver
    {
        return $this->idScalarTypeResolver ??= $this->getInstanceManager()->getInstance(IDScalarTypeResolver::class);
    }
    public function setStringScalarTypeResolver(StringScalarTypeResolver $stringScalarTypeResolver): void
    {
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
    }
    protected function getStringScalarTypeResolver(): StringScalarTypeResolver
    {
        return $this->stringScalarTypeResolver ??= $this->getInstanceManager()->getInstance(StringScalarTypeResolver::class);
    }
    public function setMenuItemObjectTypeResolver(MenuItemObjectTypeResolver $menuItemObjectTypeResolver): void
    {
        $this->menuItemObjectTypeResolver = $menuItemObjectTypeResolver;
    }
    protected function getMenuItemObjectTypeResolver(): MenuItemObjectTypeResolver
    {
        return $this->menuItemObjectTypeResolver ??= $this->getInstanceManager()->getInstance(MenuItemObjectTypeResolver::class);
    }

    //#[Required]
    final public function autowireMenuItemObjectTypeFieldResolver(
        MenuItemRuntimeRegistryInterface $menuItemRuntimeRegistry,
        CMSHelperServiceInterface $cmsHelperService,
        URLScalarTypeResolver $urlScalarTypeResolver,
        IDScalarTypeResolver $idScalarTypeResolver,
        StringScalarTypeResolver $stringScalarTypeResolver,
        MenuItemObjectTypeResolver $menuItemObjectTypeResolver,
    ): void {
        $this->menuItemRuntimeRegistry = $menuItemRuntimeRegistry;
        $this->cmsHelperService = $cmsHelperService;
        $this->urlScalarTypeResolver = $urlScalarTypeResolver;
        $this->idScalarTypeResolver = $idScalarTypeResolver;
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
        $this->menuItemObjectTypeResolver = $menuItemObjectTypeResolver;
    }

    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            MenuItemObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            // This field is special in that it is retrieved from the registry
            'children',
            'localURLPath',
            // All other fields are properties in the object
            'label',
            'title',
            'url',
            'classes',
            'target',
            'description',
            'objectID',
            'parentID',
            'linkRelationship',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'children' => $this->getMenuItemObjectTypeResolver(),
            'localURLPath' => $this->getStringScalarTypeResolver(),
            'label' => $this->getStringScalarTypeResolver(),
            'title' => $this->getStringScalarTypeResolver(),
            'url' => $this->getUrlScalarTypeResolver(),
            'classes' => $this->getStringScalarTypeResolver(),
            'target' => $this->getStringScalarTypeResolver(),
            'description' => $this->getStringScalarTypeResolver(),
            'objectID' => $this->getIdScalarTypeResolver(),
            'parentID' => $this->getIdScalarTypeResolver(),
            'linkRelationship' => $this->getStringScalarTypeResolver(),
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'children',
            'classes'
                => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'children' => $this->getTranslationAPI()->__('Menu item children items', 'menus'),
            'label' => $this->getTranslationAPI()->__('Menu item label', 'menus'),
            'title' => $this->getTranslationAPI()->__('Menu item title', 'menus'),
            'localURLPath' => $this->getTranslationAPI()->__('Path of a local URL, or null if external URL', 'menus'),
            'url' => $this->getTranslationAPI()->__('Menu item URL', 'menus'),
            'classes' => $this->getTranslationAPI()->__('Menu item classes', 'menus'),
            'target' => $this->getTranslationAPI()->__('Menu item target', 'menus'),
            'description' => $this->getTranslationAPI()->__('Menu item additional attributes', 'menus'),
            'objectID' => $this->getTranslationAPI()->__('ID of the object linked to by the menu item ', 'menus'),
            'parentID' => $this->getTranslationAPI()->__('Menu item\'s parent ID', 'menus'),
            'linkRelationship' => $this->getTranslationAPI()->__('Link relationship (XFN)', 'menus'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        /** @var MenuItem */
        $menuItem = $object;
        switch ($fieldName) {
            case 'children':
                return array_keys($this->getMenuItemRuntimeRegistry()->getMenuItemChildren($objectTypeResolver->getID($menuItem)));
            case 'localURLPath':
                $url = $menuItem->url;
                $pathURL = $this->getCmsHelperService()->getLocalURLPath($url);
                if ($pathURL === false) {
                    return null;
                }
                return $pathURL;
            // These are all properties of MenuItem
            // Commented out since this is the default FieldResolver's response
            // case 'label':
            // case 'title':
            // case 'url':
            // case 'classes':
            // case 'target':
            // case 'description':
            // case 'objectID':
            // case 'parentID':
            // case 'linkRelationship':
            //     return $menuItem->$fieldName;
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
