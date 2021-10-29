<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\RelationalTypeResolverDecorators;

use PoP\AccessControl\RelationalTypeResolverDecorators\AbstractPublicSchemaRelationalTypeResolverDecorator;
use PoP\AccessControl\RelationalTypeResolverDecorators\ConfigurableAccessControlForFieldsRelationalTypeResolverDecoratorTrait;
use PoP\AccessControl\Services\AccessControlManagerInterface;
use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver;
use PoPSchema\UserRolesAccessControl\Services\AccessControlGroups;
use Symfony\Contracts\Service\Attribute\Required;

class ValidateDoesLoggedInUserHaveCapabilityForFieldsPublicSchemaRelationalTypeResolverDecorator extends AbstractPublicSchemaRelationalTypeResolverDecorator
{
    use ConfigurableAccessControlForFieldsRelationalTypeResolverDecoratorTrait;
    use ValidateDoesLoggedInUserHaveCapabilityPublicSchemaRelationalTypeResolverDecoratorTrait;

    protected ?AccessControlManagerInterface $accessControlManager = null;
    protected ?ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver $validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver = null;

    public function setAccessControlManager(AccessControlManagerInterface $accessControlManager): void
    {
        $this->accessControlManager = $accessControlManager;
    }
    protected function getAccessControlManager(): AccessControlManagerInterface
    {
        return $this->accessControlManager ??= $this->getInstanceManager()->getInstance(AccessControlManagerInterface::class);
    }
    public function setValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver(ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver $validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver): void
    {
        $this->validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver = $validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver;
    }
    protected function getValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver(): ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver
    {
        return $this->validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver ??= $this->getInstanceManager()->getInstance(ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver::class);
    }

    //#[Required]
    final public function autowireValidateDoesLoggedInUserHaveCapabilityForFieldsPublicSchemaRelationalTypeResolverDecorator(
        AccessControlManagerInterface $accessControlManager,
        ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver $validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver,
    ): void {
        $this->accessControlManager = $accessControlManager;
        $this->validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver = $validateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver;
    }

    protected function getConfigurationEntries(): array
    {
        return $this->getAccessControlManager()->getEntriesForFields(AccessControlGroups::CAPABILITIES);
    }

    protected function getValidateCapabilityDirectiveResolver(): DirectiveResolverInterface
    {
        return $this->getValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver();
    }
}
