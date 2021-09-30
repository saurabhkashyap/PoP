<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\DirectiveResolvers;

use PoP\ComponentModel\DirectiveResolvers\AbstractValidateConditionDirectiveResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\Engine\TypeResolvers\ScalarType\StringScalarTypeResolver;
use PoPSchema\UserRoles\TypeAPIs\UserRoleTypeAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver extends AbstractValidateConditionDirectiveResolver
{
    protected UserRoleTypeAPIInterface $userRoleTypeAPI;
    protected StringScalarTypeResolver $stringScalarTypeResolver;

    #[Required]
    public function autowireValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver(
        UserRoleTypeAPIInterface $userRoleTypeAPI,
        StringScalarTypeResolver $stringScalarTypeResolver,
    ): void {
        $this->userRoleTypeAPI = $userRoleTypeAPI;
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
    }

    public function getDirectiveName(): string
    {
        return 'validateDoesLoggedInUserHaveAnyRole';
    }

    protected function validateCondition(RelationalTypeResolverInterface $relationalTypeResolver): bool
    {
        $vars = ApplicationState::getVars();
        // If the user is not logged-in, then do nothing: directive `@validateIsUserLoggedIn` will already fail
        if (!$vars['global-userstate']['is-user-logged-in']) {
            return true;
        }

        $roles = $this->directiveArgsForSchema['roles'];
        $userID = $vars['global-userstate']['current-user-id'];
        $userRoles = $this->userRoleTypeAPI->getUserRoles($userID);
        return !empty(array_intersect($roles, $userRoles));
    }

    protected function getValidationFailedMessage(RelationalTypeResolverInterface $relationalTypeResolver, array $failedDataFields): string
    {
        $roles = $this->directiveArgsForSchema['roles'];
        $isValidatingDirective = $this->isValidatingDirective();
        if (count($roles) == 1) {
            $errorMessage = $isValidatingDirective ?
                $this->translationAPI->__('You must have role \'%s\' to access directives in field(s) \'%s\' for type \'%s\'', 'user-roles') :
                $this->translationAPI->__('You must have role \'%s\' to access field(s) \'%s\' for type \'%s\'', 'user-roles');
        } else {
            $errorMessage = $isValidatingDirective ?
                $this->translationAPI->__('You must have any role from among \'%s\' to access directives in field(s) \'%s\' for type \'%s\'', 'user-roles') :
                $this->translationAPI->__('You must have any role from among \'%s\' to access field(s) \'%s\' for type \'%s\'', 'user-roles');
        }
        return sprintf(
            $errorMessage,
            implode(
                $this->translationAPI->__('\', \''),
                $roles
            ),
            implode(
                $this->translationAPI->__('\', \''),
                $failedDataFields
            ),
            $relationalTypeResolver->getMaybeNamespacedTypeName()
        );
    }

    public function getSchemaDirectiveDescription(RelationalTypeResolverInterface $relationalTypeResolver): ?string
    {
        return $this->translationAPI->__('It validates if the user has any of the roles provided through directive argument \'roles\'', 'component-model');
    }
    public function getSchemaDirectiveArgNameResolvers(RelationalTypeResolverInterface $relationalTypeResolver): array
    {
        return [

        ];
    }

    public function getSchemaDirectiveArgDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $directiveArgName): ?string
    {
        return match ($directiveArgName) {
            default => parent::getSchemaDirectiveArgDescription($relationalTypeResolver, $directiveArgName),
        };
    }

    public function getSchemaDirectiveArgDefaultValue(RelationalTypeResolverInterface $relationalTypeResolver, string $directiveArgName): mixed
    {
        return match ($directiveArgName) {
            default => parent::getSchemaDirectiveArgDefaultValue($relationalTypeResolver, $directiveArgName),
        };
    }

    public function getSchemaDirectiveArgTypeModifiers(RelationalTypeResolverInterface $relationalTypeResolver, string $directiveArgName): ?int
    {
        return match ($directiveArgName) {
            default => parent::getSchemaDirectiveArgTypeModifiers($relationalTypeResolver, $directiveArgName),
        };
    }

    public function getSchemaDirectiveArgs(RelationalTypeResolverInterface $relationalTypeResolver): array
    {
        return [
            [
                SchemaDefinition::ARGNAME_NAME => 'roles',
                SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_STRING,
                SchemaDefinition::ARGNAME_IS_ARRAY => true,
                SchemaDefinition::ARGNAME_DESCRIPTION => $this->translationAPI->__('Roles to validate if the logged-in user has (any of them)', 'component-model'),
                SchemaDefinition::ARGNAME_MANDATORY => true,
            ],
        ];
    }
}
