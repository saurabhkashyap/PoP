<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\PluginManagement;

use GraphQLAPI\GraphQLAPI\PluginSkeleton\AbstractMainPlugin;

class MainPluginManager extends AbstractPluginManager
{
    private static ?AbstractMainPlugin $mainPlugin = null;

    public static function register(AbstractMainPlugin $mainPlugin): AbstractMainPlugin
    {
        /**
         * Validate it hasn't been registered yet, as to
         * make sure this plugin is not duplicated.
         * For instance, if zip file already exists in Downloads folder, then
         * the newly downloaded file will be renamed (eg: graphql-api(2).zip)
         * and the plugin will exist twice, as graphql-api/... and graphql-api2/...
         */
        if (self::$mainPlugin !== null) {
            self::printAdminNoticeErrorMessage(
                sprintf(
                    __('Plugin <strong>%s</strong> is already installed with version <code>%s</code>, so version <code>%s</code> has not been loaded. Please deactivate all versions, remove the older version, and activate again the latest version of the plugin.', 'graphql-api'),
                    $mainPlugin->getConfig('name'),
                    self::$mainPlugin->getConfig('version'),
                    $mainPlugin->getConfig('version'),
                )
            );
            return self::$mainPlugin;
        }

        self::$mainPlugin = $mainPlugin;
        return $mainPlugin;
    }

    /**
     * Get the configuration for the main plugin
     *
     * @return array<string, mixed>
     */
    protected static function getFullConfiguration(): array
    {
        return self::$mainPlugin->getFullConfiguration();
    }

    /**
     * Get a configuration value for the main plugin
     *
     * @return array<string, mixed>
     */
    public static function getConfig(string $key): mixed
    {
        $mainPluginConfig = self::getFullConfiguration();
        return $mainPluginConfig[$key];
    }
}
