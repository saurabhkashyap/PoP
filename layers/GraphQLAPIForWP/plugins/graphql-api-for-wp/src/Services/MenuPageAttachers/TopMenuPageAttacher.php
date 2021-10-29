<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\MenuPageAttachers;

use GraphQLAPI\GraphQLAPI\Registries\ModuleRegistryInterface;
use GraphQLAPI\GraphQLAPI\Security\UserAuthorizationInterface;
use GraphQLAPI\GraphQLAPI\Services\Helpers\MenuPageHelper;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\GraphiQLMenuPage;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\GraphQLVoyagerMenuPage;
use Symfony\Contracts\Service\Attribute\Required;

class TopMenuPageAttacher extends AbstractPluginMenuPageAttacher
{
    protected ?MenuPageHelper $menuPageHelper = null;
    protected ?ModuleRegistryInterface $moduleRegistry = null;
    protected ?UserAuthorizationInterface $userAuthorization = null;
    protected ?GraphiQLMenuPage $graphiQLMenuPage = null;
    protected ?GraphQLVoyagerMenuPage $graphQLVoyagerMenuPage = null;

    public function setMenuPageHelper(MenuPageHelper $menuPageHelper): void
    {
        $this->menuPageHelper = $menuPageHelper;
    }
    protected function getMenuPageHelper(): MenuPageHelper
    {
        return $this->menuPageHelper ??= $this->getInstanceManager()->getInstance(MenuPageHelper::class);
    }
    public function setModuleRegistry(ModuleRegistryInterface $moduleRegistry): void
    {
        $this->moduleRegistry = $moduleRegistry;
    }
    protected function getModuleRegistry(): ModuleRegistryInterface
    {
        return $this->moduleRegistry ??= $this->getInstanceManager()->getInstance(ModuleRegistryInterface::class);
    }
    public function setUserAuthorization(UserAuthorizationInterface $userAuthorization): void
    {
        $this->userAuthorization = $userAuthorization;
    }
    protected function getUserAuthorization(): UserAuthorizationInterface
    {
        return $this->userAuthorization ??= $this->getInstanceManager()->getInstance(UserAuthorizationInterface::class);
    }
    public function setGraphiQLMenuPage(GraphiQLMenuPage $graphiQLMenuPage): void
    {
        $this->graphiQLMenuPage = $graphiQLMenuPage;
    }
    protected function getGraphiQLMenuPage(): GraphiQLMenuPage
    {
        return $this->graphiQLMenuPage ??= $this->getInstanceManager()->getInstance(GraphiQLMenuPage::class);
    }
    public function setGraphQLVoyagerMenuPage(GraphQLVoyagerMenuPage $graphQLVoyagerMenuPage): void
    {
        $this->graphQLVoyagerMenuPage = $graphQLVoyagerMenuPage;
    }
    protected function getGraphQLVoyagerMenuPage(): GraphQLVoyagerMenuPage
    {
        return $this->graphQLVoyagerMenuPage ??= $this->getInstanceManager()->getInstance(GraphQLVoyagerMenuPage::class);
    }

    //#[Required]
    final public function autowireTopMenuPageAttacher(
        MenuPageHelper $menuPageHelper,
        ModuleRegistryInterface $moduleRegistry,
        UserAuthorizationInterface $userAuthorization,
        GraphiQLMenuPage $graphiQLMenuPage,
        GraphQLVoyagerMenuPage $graphQLVoyagerMenuPage,
    ): void {
        $this->menuPageHelper = $menuPageHelper;
        $this->moduleRegistry = $moduleRegistry;
        $this->userAuthorization = $userAuthorization;
        $this->graphiQLMenuPage = $graphiQLMenuPage;
        $this->graphQLVoyagerMenuPage = $graphQLVoyagerMenuPage;
    }

    /**
     * Before adding the menus for the CPTs
     */
    protected function getPriority(): int
    {
        return 6;
    }

    public function addMenuPages(): void
    {
        $schemaEditorAccessCapability = $this->getUserAuthorization()->getSchemaEditorAccessCapability();

        if (
            $hookName = \add_submenu_page(
                $this->getMenuName(),
                __('GraphiQL', 'graphql-api'),
                __('GraphiQL', 'graphql-api'),
                $schemaEditorAccessCapability,
                $this->getMenuName(),
                [$this->getGraphiQLMenuPage(), 'print']
            )
        ) {
            $this->getGraphiQLMenuPage()->setHookName($hookName);
        }

        if (
            $hookName = \add_submenu_page(
                $this->getMenuName(),
                __('Interactive Schema', 'graphql-api'),
                __('Interactive Schema', 'graphql-api'),
                $schemaEditorAccessCapability,
                $this->getGraphQLVoyagerMenuPage()->getScreenID(),
                [$this->getGraphQLVoyagerMenuPage(), 'print']
            )
        ) {
            $this->getGraphQLVoyagerMenuPage()->setHookName($hookName);
        }
    }
}
