<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\ObjectModels;

use PoP\ComponentModel\Schema\SchemaDefinition;

class DirectiveExtensions extends AbstractSchemaDefinitionReferenceObject
{
    public function needsDataToExecute(): bool
    {
        return $this->schemaDefinition[SchemaDefinition::DIRECTIVE_NEEDS_DATA_TO_EXECUTE];
    }
}
