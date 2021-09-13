<?php

declare(strict_types=1);

namespace PoPSchema\UserStateAccessControl\ConditionalOnComponent\CacheControl\RelationalTypeResolverDecorators;

use PoPSchema\UserStateAccessControl\RelationalTypeResolverDecorators\ValidateUserNotLoggedInForDirectivesRelationalTypeResolverDecoratorTrait;

class ValidateUserNotLoggedInForDirectivesPrivateSchemaRelationalTypeResolverDecorator extends AbstractNoCacheConfigurableAccessControlForDirectivesInPrivateSchemaRelationalTypeResolverDecorator
{
    use ValidateUserNotLoggedInForDirectivesRelationalTypeResolverDecoratorTrait;
}