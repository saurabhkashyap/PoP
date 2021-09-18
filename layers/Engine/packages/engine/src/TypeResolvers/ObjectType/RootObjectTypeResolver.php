<?php

declare(strict_types=1);

namespace PoP\Engine\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoP\ComponentModel\Facades\Schema\SchemaDefinitionServiceFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;
use PoP\Engine\ObjectModels\Root;
use PoP\Engine\RelationalTypeDataLoaders\ObjectType\RootTypeDataLoader;
use PoP\Engine\TypeResolvers\ReservedNameTypeResolverTrait;

class RootObjectTypeResolver extends AbstractObjectTypeResolver
{
    use ReservedNameTypeResolverTrait;

    public const HOOK_DESCRIPTION = __CLASS__ . ':description';

    public function __construct(
        \PoP\Translation\TranslationAPIInterface $translationAPI,
        \PoP\Hooks\HooksAPIInterface $hooksAPI,
        \PoP\ComponentModel\Instances\InstanceManagerInterface $instanceManager,
        \PoP\ComponentModel\Schema\SchemaNamespacingServiceInterface $schemaNamespacingService,
        \PoP\ComponentModel\Schema\SchemaDefinitionServiceInterface $schemaDefinitionService,
        \PoP\ComponentModel\Schema\FeedbackMessageStoreInterface $feedbackMessageStore,
        \PoP\ComponentModel\Schema\FieldQueryInterpreterInterface $fieldQueryInterpreter,
        \PoP\ComponentModel\ErrorHandling\ErrorProviderInterface $errorProvider,
    ) {
        parent::__construct(
            $translationAPI,
            $hooksAPI,
            $instanceManager,
            $schemaNamespacingService,
            $schemaDefinitionService,
            $feedbackMessageStore,
            $fieldQueryInterpreter,
            $errorProvider,
        );
    }
    
    public function getTypeName(): string
    {
        return 'Root';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->hooksAPI->applyFilters(
            self::HOOK_DESCRIPTION,
            $this->translationAPI->__('Root type, starting from which the query is executed', 'api')
        );
    }

    public function getID(object $object): string | int | null
    {
        /** @var Root */
        $root = $object;
        return $root->getID();
    }

    public function getRelationalTypeDataLoaderClass(): RelationalTypeDataLoaderInterface
    {
        return RootTypeDataLoader::class;
    }

    protected function addSchemaDefinition(array $stackMessages, array &$generalMessages, array $options = [])
    {
        parent::addSchemaDefinition($stackMessages, $generalMessages, $options);

        // Only in the root we output the operators and helpers
        $schemaDefinitionService = SchemaDefinitionServiceFacade::getInstance();
        $typeSchemaKey = $schemaDefinitionService->getTypeSchemaKey($this);

        // Add the directives (global)
        $this->schemaDefinition[$typeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_DIRECTIVES] = [];
        $schemaDirectiveResolvers = $this->getSchemaDirectiveResolvers(true);
        foreach ($schemaDirectiveResolvers as $directiveName => $directiveResolver) {
            $this->schemaDefinition[$typeSchemaKey][SchemaDefinition::ARGNAME_GLOBAL_DIRECTIVES][$directiveName] = $this->getDirectiveSchemaDefinition($directiveResolver, $options);
        }

        // Add the fields (global)
        $schemaObjectTypeFieldResolvers = $this->getSchemaObjecTypeObjectTypeFieldResolvers(true);
        foreach ($schemaObjectTypeFieldResolvers as $fieldName => $objectTypeFieldResolver) {
            $this->addFieldSchemaDefinition($objectTypeFieldResolver, $fieldName, $stackMessages, $generalMessages, $options);
        }
    }
}
