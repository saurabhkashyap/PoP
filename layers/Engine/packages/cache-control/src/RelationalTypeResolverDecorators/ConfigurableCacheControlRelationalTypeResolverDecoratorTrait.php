<?php

declare(strict_types=1);

namespace PoP\CacheControl\RelationalTypeResolverDecorators;

use PoP\CacheControl\DirectiveResolvers\CacheControlDirectiveResolver;
use PoP\ComponentModel\Schema\FieldQueryInterpreterInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait ConfigurableCacheControlRelationalTypeResolverDecoratorTrait
{
    protected ?FieldQueryInterpreterInterface $fieldQueryInterpreter = null;
    protected ?CacheControlDirectiveResolver $cacheControlDirectiveResolver = null;

    public function setFieldQueryInterpreter(FieldQueryInterpreterInterface $fieldQueryInterpreter): void
    {
        $this->fieldQueryInterpreter = $fieldQueryInterpreter;
    }
    protected function getFieldQueryInterpreter(): FieldQueryInterpreterInterface
    {
        return $this->fieldQueryInterpreter ??= $this->getInstanceManager()->getInstance(FieldQueryInterpreterInterface::class);
    }
    public function setCacheControlDirectiveResolver(CacheControlDirectiveResolver $cacheControlDirectiveResolver): void
    {
        $this->cacheControlDirectiveResolver = $cacheControlDirectiveResolver;
    }
    protected function getCacheControlDirectiveResolver(): CacheControlDirectiveResolver
    {
        return $this->cacheControlDirectiveResolver ??= $this->getInstanceManager()->getInstance(CacheControlDirectiveResolver::class);
    }

    //#[Required]
    public function autowireConfigurableCacheControlRelationalTypeResolverDecoratorTrait(
        FieldQueryInterpreterInterface $fieldQueryInterpreter,
        CacheControlDirectiveResolver $cacheControlDirectiveResolver,
    ): void {
        $this->fieldQueryInterpreter = $fieldQueryInterpreter;
        $this->cacheControlDirectiveResolver = $cacheControlDirectiveResolver;
    }

    /**
     * By default, only the admin can see the roles from the users
     */
    protected function getMandatoryDirectives(mixed $entryValue = null): array
    {
        $maxAge = $entryValue;
        $cacheControlDirective = $this->getFieldQueryInterpreter()->getDirective(
            $this->getCacheControlDirectiveResolver()->getDirectiveName(),
            [
                'maxAge' => $maxAge,
            ]
        );
        return [
            $cacheControlDirective,
        ];
    }
}
