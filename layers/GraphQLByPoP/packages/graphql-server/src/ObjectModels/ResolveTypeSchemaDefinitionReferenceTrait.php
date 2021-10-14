<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\ObjectModels;

use GraphQLByPoP\GraphQLServer\Facades\Registries\SchemaDefinitionReferenceRegistryFacade;
use GraphQLByPoP\GraphQLServer\Schema\SchemaDefinitionTypes as GraphQLServerSchemaDefinitionTypes;
use GraphQLByPoP\GraphQLServer\Schema\SchemaDefinitionHelpers;
use GraphQLByPoP\GraphQLServer\Syntax\SyntaxHelpers;
use PoP\API\Schema\SchemaDefinition;

trait ResolveTypeSchemaDefinitionReferenceTrait
{
    protected function getTypeFromTypeName(string $typeName): AbstractType
    {
        // Check if the type is non-null
        if (SyntaxHelpers::isNonNullType($typeName)) {
            return new NonNullType(
                $this->fullSchemaDefinition,
                $this->schemaDefinitionPath,
                $this->getTypeFromTypeName(
                    SyntaxHelpers::getNonNullTypeNestedTypeName($typeName)
                )
            );
        }

        // Check if it is an array
        if (SyntaxHelpers::isListType($typeName)) {
            return new ListType(
                $this->fullSchemaDefinition,
                $this->schemaDefinitionPath,
                $this->getTypeFromTypeName(
                    SyntaxHelpers::getListTypeNestedTypeName($typeName)
                )
            );
        }

        // Check if it is an enum type
        // @todo Added temporary hack. Fix this!
        // if ($typeName == GraphQLServerSchemaDefinitionTypes::TYPE_ENUM) {
        if (in_array($typeName, [
            'CommentStatus',
            'CommentType',
            'DefaultCondition',
            'CustomPostStatus',
            'CustomPostContentFormat',
            'MediaDevice',
            'EventScope',
        ])) {
            return new EnumType(
                $this->fullSchemaDefinition,
                $this->schemaDefinitionPath
            );
        }

        // Check if it is an inputObject type
        if ($typeName == GraphQLServerSchemaDefinitionTypes::TYPE_INPUT_OBJECT) {
            return new InputObjectType(
                $this->fullSchemaDefinition,
                $this->schemaDefinitionPath
            );
        }

        // By now, it's either an InterfaceType, UnionType, ObjectType or a ScalarType. Since they have all been registered, we can get their references from the registry
        $typeSchemaDefinitionPath = [
            SchemaDefinition::TYPES,
            $typeName,
        ];
        $schemaDefinitionID = SchemaDefinitionHelpers::getID($typeSchemaDefinitionPath);
        $schemaDefinitionReferenceRegistry = SchemaDefinitionReferenceRegistryFacade::getInstance();
        /** @var AbstractType */
        return $schemaDefinitionReferenceRegistry->getSchemaDefinitionReference($schemaDefinitionID);
    }
}
