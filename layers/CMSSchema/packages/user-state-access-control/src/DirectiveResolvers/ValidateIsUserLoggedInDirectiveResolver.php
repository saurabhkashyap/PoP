<?php

declare(strict_types=1);

namespace PoPCMSSchema\UserStateAccessControl\DirectiveResolvers;

use PoP\ComponentModel\DirectiveResolvers\AbstractValidateCheckpointDirectiveResolver;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoPCMSSchema\UserState\CheckpointSets\UserStateCheckpointSets;

class ValidateIsUserLoggedInDirectiveResolver extends AbstractValidateCheckpointDirectiveResolver
{
    public function getDirectiveName(): string
    {
        return 'validateIsUserLoggedIn';
    }

    protected function getValidationCheckpointSet(RelationalTypeResolverInterface $relationalTypeResolver): array
    {
        return UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER;
    }

    protected function getValidationFailedMessage(RelationalTypeResolverInterface $relationalTypeResolver, array $failedDataFields): string
    {
        $errorMessage = $this->isValidatingDirective() ?
            $this->__('You must be logged in to access directives in field(s) \'%s\' for type \'%s\'', 'user-state') :
            $this->__('You must be logged in to access field(s) \'%s\' for type \'%s\'', 'user-state');
        return sprintf(
            $errorMessage,
            implode(
                $this->__('\', \''),
                $failedDataFields
            ),
            $relationalTypeResolver->getMaybeNamespacedTypeName()
        );
    }

    public function getDirectiveDescription(RelationalTypeResolverInterface $relationalTypeResolver): ?string
    {
        return $this->__('It validates if the user is logged-in', 'component-model');
    }
}
