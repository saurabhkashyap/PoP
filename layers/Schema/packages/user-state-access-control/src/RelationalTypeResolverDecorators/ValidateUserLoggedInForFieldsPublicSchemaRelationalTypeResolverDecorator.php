<?php

declare(strict_types=1);

namespace PoPSchema\UserStateAccessControl\RelationalTypeResolverDecorators;


class ValidateUserLoggedInForFieldsPublicSchemaRelationalTypeResolverDecorator extends AbstractUserStateConfigurableAccessControlForFieldsInPublicSchemaRelationalTypeResolverDecorator
{
    use ValidateUserLoggedInForFieldsRelationalTypeResolverDecoratorTrait;
}
