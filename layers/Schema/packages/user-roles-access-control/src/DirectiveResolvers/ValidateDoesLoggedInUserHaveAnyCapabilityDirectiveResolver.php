<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\DirectiveResolvers;

use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoPSchema\UserRoles\Facades\UserRoleTypeAPIFacade;
use PoP\ComponentModel\TypeResolvers\Object\ObjectTypeResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\AbstractValidateConditionDirectiveResolver;

class ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver extends AbstractValidateConditionDirectiveResolver
{
    public function getDirectiveName(): string
    {
        return 'validateDoesLoggedInUserHaveAnyCapability';
    }

    protected function validateCondition(ObjectTypeResolverInterface $objectTypeResolver): bool
    {
        $vars = ApplicationState::getVars();
        // If the user is not logged-in, then do nothing: directive `@validateIsUserLoggedIn` will already fail
        if (!$vars['global-userstate']['is-user-logged-in']) {
            return true;
        }

        $capabilities = $this->directiveArgsForSchema['capabilities'];
        $userRoleTypeAPI = UserRoleTypeAPIFacade::getInstance();
        $userID = $vars['global-userstate']['current-user-id'];
        $userCapabilities = $userRoleTypeAPI->getUserCapabilities($userID);
        return !empty(array_intersect($capabilities, $userCapabilities));
    }

    protected function getValidationFailedMessage(ObjectTypeResolverInterface $objectTypeResolver, array $failedDataFields): string
    {
        $capabilities = $this->directiveArgsForSchema['capabilities'];
        $isValidatingDirective = $this->isValidatingDirective();
        if (count($capabilities) == 1) {
            $errorMessage = $isValidatingDirective ?
                $this->translationAPI->__('You must have capability \'%s\' to access directives in field(s) \'%s\' for type \'%s\'', 'user-roles') :
                $this->translationAPI->__('You must have capability \'%s\' to access field(s) \'%s\' for type \'%s\'', 'user-roles');
        } else {
            $errorMessage = $isValidatingDirective ?
                $this->translationAPI->__('You must have any capability from among \'%s\' to access directives in field(s) \'%s\' for type \'%s\'', 'user-roles') :
                $this->translationAPI->__('You must have any capability from among \'%s\' to access field(s) \'%s\' for type \'%s\'', 'user-roles');
        }
        return sprintf(
            $errorMessage,
            implode(
                $this->translationAPI->__('\', \''),
                $capabilities
            ),
            implode(
                $this->translationAPI->__('\', \''),
                $failedDataFields
            ),
            $objectTypeResolver->getMaybeNamespacedTypeName()
        );
    }

    public function getSchemaDirectiveDescription(ObjectTypeResolverInterface $objectTypeResolver): ?string
    {
        return $this->translationAPI->__('It validates if the user has any capability provided through directive argument \'capabilities\'', 'component-model');
    }
    public function getSchemaDirectiveArgs(ObjectTypeResolverInterface $objectTypeResolver): array
    {
        return [
            [
                SchemaDefinition::ARGNAME_NAME => 'capabilities',
                SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_STRING,
                SchemaDefinition::ARGNAME_IS_ARRAY => true,
                SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('Capabilities to validate if the logged-in user has (any of them)', 'component-model'),
                SchemaDefinition::ARGNAME_MANDATORY => true,
            ],
        ];
    }
}
