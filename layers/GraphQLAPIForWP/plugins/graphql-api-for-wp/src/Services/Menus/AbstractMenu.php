<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Menus;

use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\Root\Services\AbstractAutomaticallyInstantiatedService;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractMenu extends AbstractAutomaticallyInstantiatedService implements MenuInterface
{
    protected ?InstanceManagerInterface $instanceManager = null;

    public function setInstanceManager(InstanceManagerInterface $instanceManager): void
    {
        $this->instanceManager = $instanceManager;
    }
    protected function getInstanceManager(): InstanceManagerInterface
    {
        return $this->instanceManager ??= $this->getInstanceManager()->getInstance(InstanceManagerInterface::class);
    }

    //#[Required]
    final public function autowireAbstractMenu(InstanceManagerInterface $instanceManager): void
    {
        $this->instanceManager = $instanceManager;
    }

    /**
     * Initialize the endpoints
     */
    public function initialize(): void
    {
        \add_action(
            'admin_menu',
            [$this, 'addMenuPage'],
            5
        );
    }
}
