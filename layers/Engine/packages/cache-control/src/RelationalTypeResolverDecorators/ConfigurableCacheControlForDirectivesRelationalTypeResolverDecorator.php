<?php

declare(strict_types=1);

namespace PoP\CacheControl\RelationalTypeResolverDecorators;

use PoP\CacheControl\Managers\CacheControlManagerInterface;
use PoP\MandatoryDirectivesByConfiguration\RelationalTypeResolverDecorators\AbstractMandatoryDirectivesForDirectivesRelationalTypeResolverDecorator;
use Symfony\Contracts\Service\Attribute\Required;

class ConfigurableCacheControlForDirectivesRelationalTypeResolverDecorator extends AbstractMandatoryDirectivesForDirectivesRelationalTypeResolverDecorator
{
    use ConfigurableCacheControlRelationalTypeResolverDecoratorTrait;

    protected ?CacheControlManagerInterface $cacheControlManager = null;

    public function setCacheControlManager(CacheControlManagerInterface $cacheControlManager): void
    {
        $this->cacheControlManager = $cacheControlManager;
    }
    protected function getCacheControlManager(): CacheControlManagerInterface
    {
        return $this->cacheControlManager ??= $this->getInstanceManager()->getInstance(CacheControlManagerInterface::class);
    }

    //#[Required]
    final public function autowireConfigurableCacheControlForDirectivesRelationalTypeResolverDecorator(
        CacheControlManagerInterface $cacheControlManager,
    ): void {
        $this->cacheControlManager = $cacheControlManager;
    }

    protected function getConfigurationEntries(): array
    {
        return $this->getCacheControlManager()->getEntriesForDirectives();
    }
}
