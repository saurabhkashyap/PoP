<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\TypeResolvers\Object;

use GraphQLByPoP\GraphQLServer\RelationalTypeDataLoaders\SchemaDefinitionReferenceTypeDataLoader;
use GraphQLByPoP\GraphQLServer\TypeResolvers\Object\AbstractIntrospectionTypeResolver;

class DirectiveTypeResolver extends AbstractIntrospectionTypeResolver
{
    public function getTypeName(): string
    {
        return '__Directive';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('A GraphQL directive in the data graph', 'graphql-server');
    }

    public function getID(object $resultItem): string | int | null
    {
        $directive = $resultItem;
        return $directive->getID();
    }

    public function getRelationalTypeDataLoaderClass(): string
    {
        return SchemaDefinitionReferenceTypeDataLoader::class;
    }
}
