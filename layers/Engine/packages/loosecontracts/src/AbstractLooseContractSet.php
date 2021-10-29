<?php

declare(strict_types=1);

namespace PoP\LooseContracts;

use PoP\Root\Services\AbstractAutomaticallyInstantiatedService;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractLooseContractSet extends AbstractAutomaticallyInstantiatedService
{
    protected ?LooseContractManagerInterface $looseContractManager = null;

    public function setLooseContractManager(LooseContractManagerInterface $looseContractManager): void
    {
        $this->looseContractManager = $looseContractManager;
    }
    protected function getLooseContractManager(): LooseContractManagerInterface
    {
        return $this->looseContractManager ??= $this->getInstanceManager()->getInstance(LooseContractManagerInterface::class);
    }

    //#[Required]
    final public function autowireAbstractLooseContractSet(LooseContractManagerInterface $looseContractManager): void
    {
        $this->looseContractManager = $looseContractManager;
    }

    final public function initialize(): void
    {
        // Require the configured hooks and names
        $this->getLooseContractManager()->requireHooks(
            $this->getRequiredHooks()
        );
        $this->getLooseContractManager()->requireNames(
            $this->getRequiredNames()
        );
    }

    /**
     * @return string[]
     */
    public function getRequiredHooks(): array
    {
        return [];
    }
    /**
     * @return string[]
     */
    public function getRequiredNames(): array
    {
        return [];
    }
}
