<?php

declare(strict_types=1);

namespace PoP\AccessControl\Hooks;

use PoP\Root\App;
use PoP\AccessControl\Module;
use PoP\AccessControl\ModuleConfiguration;
use PoP\AccessControl\Schema\SchemaModes;

abstract class AbstractAccessControlForFieldsInPrivateSchemaHookSet extends AbstractAccessControlForFieldsHookSet
{
    /**
     * Indicate if this hook is enabled
     */
    protected function enabled(): bool
    {
        /** @var ModuleConfiguration */
        $componentConfiguration = App::getComponent(Module::class)->getConfiguration();
        return $componentConfiguration->canSchemaBePrivate();
    }

    protected function getSchemaMode(): string
    {
        return SchemaModes::PRIVATE_SCHEMA_MODE;
    }
}
