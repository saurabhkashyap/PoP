<?php

declare(strict_types=1);

namespace PoP\API\ObjectModels\SchemaDefinition;

use PoP\API\Schema\SchemaDefinition;
use PoP\ComponentModel\TypeResolvers\ScalarType\ScalarTypeResolverInterface;

class ScalarTypeSchemaDefinitionProvider extends AbstractTypeSchemaDefinitionProvider
{
    public function __construct(
        protected ScalarTypeResolverInterface $scalarTypeResolver,
    ) {  
    }
    
    public function getType(): string
    {
        return SchemaDefinition::TYPE_SCALAR;
    }
    
    public function getSchemaDefinition(): array
    {
        return [];
    }

    public function getAccessedTypeResolvers(): array
    {
        return [];
    }
}
