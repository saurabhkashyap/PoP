<?php

declare(strict_types=1);

namespace PoP\ComponentModel\TypeResolvers\UnionType;

use PoP\ComponentModel\ComponentConfiguration;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;

use function substr;
use function explode;

class UnionTypeHelpers
{
    /**
     * If the type data resolver starts with "*" then it's union
     */
    public static function isUnionType(string $type): bool
    {
        return substr($type, 0, strlen(UnionTypeSymbols::UNION_TYPE_NAME_PREFIX)) == UnionTypeSymbols::UNION_TYPE_NAME_PREFIX;
    }

    public static function getUnionTypeCollectionName(string $type): string
    {
        return UnionTypeSymbols::UNION_TYPE_NAME_PREFIX . $type;
    }

    /**
     * Extract the original Union type name (i.e. without "*")
     */
    public static function removePrefixFromUnionTypeName(string $unionTypeCollectionName): string
    {
        return substr($unionTypeCollectionName, strlen(UnionTypeSymbols::UNION_TYPE_NAME_PREFIX));
    }

    /**
     * Extracts the DB key and ID from the resultItem ID
     */
    public static function extractDBObjectTypeAndID(string $composedDBKeyResultItemID): array
    {
        $parts = explode(
            UnionTypeSymbols::DBOBJECT_COMPOSED_TYPE_ID_SEPARATOR,
            $composedDBKeyResultItemID
        );
        // If the object could not be loaded, $composedDBKeyResultItemID will be all ID, with no $dbKey
        if (count($parts) === 1) {
            return ['', $parts[0]];
        }
        return $parts;
    }

    /**
     * Extracts the ID from the resultItem ID
     */
    public static function extractDBObjectID(string $composedDBObjectTypeAndID): string | int
    {
        $elements = explode(
            UnionTypeSymbols::DBOBJECT_COMPOSED_TYPE_ID_SEPARATOR,
            $composedDBObjectTypeAndID
        );
        // If the UnionTypeResolver didn't have a TypeResolver to process the passed object, the Type will not be added
        // In that case, the ID will be on the first position
        return count($elements) == 1 ? $elements[0] : $elements[1];
    }

    /**
     * Creates a composed string containing the type and ID of the dbObject
     */
    public static function getDBObjectComposedTypeAndID(RelationalTypeResolverInterface $relationalTypeResolver, int | string $id): string
    {
        return
            $relationalTypeResolver->getTypeOutputName() .
            UnionTypeSymbols::DBOBJECT_COMPOSED_TYPE_ID_SEPARATOR .
            (string) $id;
    }

    /**
     * Return a class or another depending on these possibilities:
     *
     * - If there is more than 1 target type resolver for the Union, return the Union
     * - (By configuration) If there is only one target, return that one directly
     *   and not the Union (since it's more efficient)
     * - If there are none types, return `null`. As a consequence,
     *   the ID is returned as a field, not as a connection
     */
    public static function getUnionOrTargetObjectTypeResolverClass(string $unionTypeResolverClass): ?string
    {
        $instanceManager = InstanceManagerFacade::getInstance();
        $unionTypeResolver = $instanceManager->getInstance($unionTypeResolverClass);
        $targetTypeResolverClasses = $unionTypeResolver->getTargetObjectTypeResolverClasses();
        if ($targetTypeResolverClasses) {
            // By configuration: If there is only 1 item, return only that one
            if (ComponentConfiguration::useSingleTypeInsteadOfUnionType()) {
                return count($targetTypeResolverClasses) == 1 ?
                    $targetTypeResolverClasses[0] :
                    $unionTypeResolverClass;
            }
            return $unionTypeResolverClass;
        }
        return null;
    }
}