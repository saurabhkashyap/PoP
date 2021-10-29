<?php

declare(strict_types=1);

namespace PoP\AccessControl\RelationalTypeResolverDecorators;

use PoP\AccessControl\Services\AccessControlManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractConfigurableAccessControlForDirectivesInPublicSchemaRelationalTypeResolverDecorator extends AbstractPublicSchemaRelationalTypeResolverDecorator
{
    use ConfigurableAccessControlForDirectivesRelationalTypeResolverDecoratorTrait;

    protected ?AccessControlManagerInterface $accessControlManager = null;

    public function setAccessControlManager(AccessControlManagerInterface $accessControlManager): void
    {
        $this->accessControlManager = $accessControlManager;
    }
    protected function getAccessControlManager(): AccessControlManagerInterface
    {
        return $this->accessControlManager ??= $this->getInstanceManager()->getInstance(AccessControlManagerInterface::class);
    }

    //#[Required]
    final public function autowireAbstractConfigurableAccessControlForDirectivesInPublicSchemaRelationalTypeResolverDecorator(
        AccessControlManagerInterface $accessControlManager,
    ): void {
        $this->accessControlManager = $accessControlManager;
    }
}
