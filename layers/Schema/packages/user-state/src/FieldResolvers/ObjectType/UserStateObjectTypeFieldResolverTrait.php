<?php

declare(strict_types=1);

namespace PoPSchema\UserState\FieldResolvers\ObjectType;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoPSchema\UserState\CheckpointSets\UserStateCheckpointSets;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\ErrorHandling\Error;

trait UserStateObjectTypeFieldResolverTrait
{
    /**
     * @param array<string, mixed> $fieldArgs
     * @return array<array>|null A checkpoint set, or null
     */
    protected function getValidationCheckpoints(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = []
    ): ?array {
        return UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER;
    }

    /**
     * @param array<string, mixed> $fieldArgs
     */
    protected function getValidationCheckpointsErrorMessage(
        Error $error,
        string $errorMessage,
        ObjectTypeResolverInterface $objectTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = []
    ): string {
        $translationAPI = TranslationAPIFacade::getInstance();
        return sprintf(
            $translationAPI->__('You must be logged in to access field \'%s\' for type \'%s\'', ''),
            $fieldName,
            $objectTypeResolver->getMaybeNamespacedTypeName()
        );
    }
}