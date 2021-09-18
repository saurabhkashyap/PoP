<?php

declare(strict_types=1);

namespace PoPSchema\PostTags\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoPSchema\PostTags\ComponentContracts\PostTagAPISatisfiedContractTrait;
use PoPSchema\PostTags\RelationalTypeDataLoaders\ObjectType\PostTagTypeDataLoader;
use PoPSchema\Tags\TypeResolvers\ObjectType\AbstractTagObjectTypeResolver;

class PostTagObjectTypeResolver extends AbstractTagObjectTypeResolver
{
    use PostTagAPISatisfiedContractTrait;

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
        return 'PostTag';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('Representation of a tag, added to a post', 'post-tags');
    }

    public function getRelationalTypeDataLoaderClass(): RelationalTypeDataLoaderInterface
    {
        return PostTagTypeDataLoader::class;
    }
}
