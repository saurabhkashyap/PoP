<?php

declare(strict_types=1);

namespace PoP\AccessControl\RelationalTypeResolverDecorators;

use PoP\AccessControl\DirectiveResolvers\DisableAccessDirectiveResolver;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractDisableAccessConfigurableAccessControlForFieldsInPublicSchemaRelationalTypeResolverDecorator extends AbstractConfigurableAccessControlForFieldsInPublicSchemaRelationalTypeResolverDecorator
{
    protected ?DisableAccessDirectiveResolver $disableAccessDirectiveResolver = null;

    public function setDisableAccessDirectiveResolver(DisableAccessDirectiveResolver $disableAccessDirectiveResolver): void
    {
        $this->disableAccessDirectiveResolver = $disableAccessDirectiveResolver;
    }
    protected function getDisableAccessDirectiveResolver(): DisableAccessDirectiveResolver
    {
        return $this->disableAccessDirectiveResolver ??= $this->getInstanceManager()->getInstance(DisableAccessDirectiveResolver::class);
    }

    //#[Required]
    final public function autowireAbstractDisableAccessConfigurableAccessControlForFieldsInPublicSchemaRelationalTypeResolverDecorator(
        DisableAccessDirectiveResolver $disableAccessDirectiveResolver,
    ): void {
        $this->disableAccessDirectiveResolver = $disableAccessDirectiveResolver;
    }

    protected function getMandatoryDirectives(mixed $entryValue = null): array
    {
        $disableAccessDirective = $this->getFieldQueryInterpreter()->getDirective(
            $this->getDisableAccessDirectiveResolver()->getDirectiveName()
        );
        return [
            $disableAccessDirective,
        ];
    }
}
