<?php

declare(strict_types=1);

namespace PoPSitesWassup\SystemMutations\MutationResolvers;

use PoP\ComponentModel\Info\ApplicationInfoInterface;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\Engine\CMS\CMSServiceInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ActivatePluginsMutationResolver extends AbstractMutationResolver
{
    protected CMSServiceInterface $cmsService;
    protected ApplicationInfoInterface $applicationInfo;

    #[Required]
    final public function autowireActivatePluginsMutationResolver(
        CMSServiceInterface $cmsService,
        ApplicationInfoInterface $applicationInfo,
    ): void {
        $this->cmsService = $cmsService;
        $this->applicationInfo = $applicationInfo;
    }

    // Taken from https://wordpress.stackexchange.com/questions/4041/how-to-activate-plugins-via-code
    private function runActivatePlugin($plugin)
    {
        $current = $this->getCmsService()->getOption('active_plugins');
        // @todo Rename package!
        // `plugin_basename` is a WordPress function,
        // so this package must be called "system-mutations-wp",
        // or have this code extracted to some WP-specific package
        $plugin = plugin_basename(trim($plugin));

        if (!in_array($plugin, $current)) {
            $current[] = $plugin;
            sort($current);
            $this->getHooksAPI()->doAction('activate_plugin', trim($plugin));
            update_option('active_plugins', $current);
            $this->getHooksAPI()->doAction('activate_' . trim($plugin));
            $this->getHooksAPI()->doAction('activated_plugin', trim($plugin));
            return true;
        }

        return false;
    }

    public function executeMutation(array $form_data): mixed
    {
        // Plugins needed by the website. Check the website version, if it's the one indicated,
        // then proceed to install the required plugin
        $plugin_version = $this->getHooksAPI()->applyFilters(
            'PoP:system-activateplugins:plugins',
            array()
        );

        // Iterate all plugins and check what version they require to be installed. If it matches the current version => activate
        $version = $this->getApplicationInfo()->getVersion();
        $activated = [];
        foreach ($plugin_version as $plugin => $activate_version) {
            if ($activate_version == $version) {
                if ($this->runActivatePlugin("${plugin}/${plugin}.php")) {
                    $activated[] = $plugin;
                }
            }
        }

        return $activated;
    }
}
