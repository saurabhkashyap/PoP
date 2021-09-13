<?php

declare(strict_types=1);

namespace PoPSchema\Locations\FieldResolvers\ObjectType;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\Engine\Route\RouteUtils;

abstract class AbstractLocationFunctionalObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    protected function getDbobjectIdField()
    {
        return null;
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'locationsmapURL',
        ];
    }

    public function getSchemaFieldType(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): string
    {
        $types = [
            'locationsmapURL' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($objectTypeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'locationsmapURL' => $this->translationAPI->__('Locations map URL', 'pop-locations'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($objectTypeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        switch ($fieldName) {
            case 'locationsmapURL':
                $locations = $objectTypeResolver->resolveValue($resultItem, 'locations', $variables, $expressions, $options);
                if (GeneralUtils::isError($locations)) {
                    return null;
                }
                return
                    // Decode it, because add_query_arg sends the params encoded and it doesn't look nice
                    urldecode(
                        // Add param "lid[]=..."
                        GeneralUtils::addQueryArgs([
                            POP_INPUTNAME_LOCATIONID => $locations,
                            // In order to keep always the same layout for the same URL, we add the param of which object we are coming from
                            // (Then, in the modal map, it will show either post/user layout, and that layout will be cached for that post/user but not for other objects)
                            $this->getDbobjectIdField() => $objectTypeResolver->getID($resultItem),
                        ], RouteUtils::getRouteURL(POP_LOCATIONS_ROUTE_LOCATIONSMAP))
                    );
        }

        return parent::resolveValue($objectTypeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}