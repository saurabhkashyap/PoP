<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\RelationalTypeResolverDecorators;

use PoP\AccessControl\RelationalTypeResolverDecorators\AbstractConfigurableAccessControlForDirectivesInPublicSchemaRelationalTypeResolverDecorator;
use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;
use PoPSchema\UserRolesAccessControl\Services\AccessControlGroups;
use Symfony\Contracts\Service\Attribute\Required;

class ValidateDoesLoggedInUserHaveRoleForDirectivesPublicSchemaRelationalTypeResolverDecorator extends AbstractConfigurableAccessControlForDirectivesInPublicSchemaRelationalTypeResolverDecorator
{
    use ValidateDoesLoggedInUserHaveRolePublicSchemaRelationalTypeResolverDecoratorTrait;

    protected ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;

    #[Required]
    final public function autowireValidateDoesLoggedInUserHaveRoleForDirectivesPublicSchemaRelationalTypeResolverDecorator(
        ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver,
    ): void {
        $this->validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver = $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;
    }

    protected function getConfigurationEntries(): array
    {
        return $this->getAccessControlManager()->getEntriesForDirectives(AccessControlGroups::ROLES);
    }

    protected function getValidateRoleDirectiveResolver(): DirectiveResolverInterface
    {
        return $this->getValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver();
    }
}
