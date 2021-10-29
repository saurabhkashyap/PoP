<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\Hooks;

use PoP\ComponentModel\State\ApplicationState;
use PoP\Engine\Cache\CacheUtils;
use PoP\Hooks\AbstractHookSet;

class SchemaCacheHookSet extends AbstractHookSet
{
    protected function init(): void
    {
        $this->getHooksAPI()->addFilter(
            CacheUtils::HOOK_SCHEMA_CACHE_KEY_COMPONENTS,
            array($this, 'getSchemaCacheKeyComponents')
        );
    }

    public function getSchemaCacheKeyComponents(array $components): array
    {
        $vars = ApplicationState::getVars();
        if ($graphQLOperationType = $vars['graphql-operation-type'] ?? null) {
            $components['graphql-operation-type'] = $graphQLOperationType;
        }
        $components['nested-mutations-enabled'] = $vars['nested-mutations-enabled'];
        return $components;
    }
}
