<?php

declare(strict_types=1);

namespace PoPSchema\Stances\TypeResolvers\ObjectType;

use PoP\Translation\TranslationAPIInterface;
use PoP\Hooks\HooksAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\Schema\SchemaNamespacingServiceInterface;
use PoP\ComponentModel\Schema\SchemaDefinitionServiceInterface;
use PoP\ComponentModel\Schema\FeedbackMessageStoreInterface;
use PoP\ComponentModel\Schema\FieldQueryInterpreterInterface;
use PoP\ComponentModel\ErrorHandling\ErrorProviderInterface;
use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoPSchema\Stances\Facades\StanceTypeAPIFacade;
use PoPSchema\Stances\RelationalTypeDataLoaders\ObjectType\StanceTypeDataLoader;
use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;

class StanceObjectTypeResolver extends AbstractObjectTypeResolver
{
    public function __construct(
        TranslationAPIInterface $translationAPI,
        HooksAPIInterface $hooksAPI,
        InstanceManagerInterface $instanceManager,
        SchemaNamespacingServiceInterface $schemaNamespacingService,
        SchemaDefinitionServiceInterface $schemaDefinitionService,
        FeedbackMessageStoreInterface $feedbackMessageStore,
        FieldQueryInterpreterInterface $fieldQueryInterpreter,
        ErrorProviderInterface $errorProvider,
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
        return 'Stance';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('A stance by the user (from among “positive”, “neutral” or “negative”) and why', 'stances');
    }

    public function getID(object $object): string | int | null
    {
        $stanceTypeAPI = StanceTypeAPIFacade::getInstance();
        return $stanceTypeAPI->getID($object);
    }

    public function getRelationalTypeDataLoaderClass(): RelationalTypeDataLoaderInterface
    {
        return StanceTypeDataLoader::class;
    }
}
