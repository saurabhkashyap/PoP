<?php

declare(strict_types=1);

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\DataToAppendAndRemoveConfig;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\DowngradeRectorConfig;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\PackageOrganizationConfig;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\PluginConfig;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\ReleaseWorkersConfig;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\UnmigratedFailingPackagesConfig;
use PoP\PoP\Extensions\Symplify\MonorepoBuilder\ValueObject\Option as CustomOption;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Neon\NeonPrinter;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $packageOrganizationConfig = new PackageOrganizationConfig(__DIR__);
    $parameters->set(
        CustomOption::PACKAGE_ORGANIZATIONS,
        $packageOrganizationConfig->getPackagePathOrganizations()
    );
    $parameters->set(
        Option::PACKAGE_DIRECTORIES,
        $packageOrganizationConfig->getPackageDirectories()
    );
    $parameters->set(
        Option::PACKAGE_DIRECTORIES_EXCLUDES,
        $packageOrganizationConfig->getPackageDirectoryExcludes()
    );

    /**
     * Plugins to generate
     */
    $pluginConfig = new PluginConfig(__DIR__);
    $parameters->set(
        CustomOption::PLUGIN_CONFIG_ENTRIES,
        $pluginConfig->getPluginConfigEntries()
    );

    /**
     * Additional downgrade Rector configs:
     * Hack to fix bugs
     * @see https://github.com/rectorphp/rector/issues/5962
     * @see https://github.com/leoloso/PoP/issues/597#issue-855005786
     */
    $downgradeRectorConfig = new DowngradeRectorConfig(__DIR__);
    $parameters->set(
        CustomOption::ADDITIONAL_DOWNGRADE_RECTOR_CONFIGS,
        $downgradeRectorConfig->getAdditionalDowngradeRectorConfigFiles()
    );

    // Temporary hack! PHPStan is currently failing for these packages,
    // because they have not been fully converted to PSR-4 (WIP),
    // and converting them will take some time. Hence, for the time being,
    // skip them from executing PHPStan, to avoid the CI from failing
    $unmigratedFailingPackagesConfig = new UnmigratedFailingPackagesConfig();
    $parameters->set(
        CustomOption::UNMIGRATED_FAILING_PACKAGES,
        $unmigratedFailingPackagesConfig->getUnmigratedFailingPackages()
    );

    $parameters = $containerConfigurator->parameters();
    $dataToAppendAndRemoveConfig = new DataToAppendAndRemoveConfig();
    $parameters->set(
        Option::DATA_TO_APPEND,
        $dataToAppendAndRemoveConfig->getDataToAppend()
    );
    $parameters->set(
        Option::DATA_TO_REMOVE,
        $dataToAppendAndRemoveConfig->getDataToRemove()
    );

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    /** Set all services */
    $services
        ->set(NeonPrinter::class) // Required to inject into PHPStanNeonContentProvider
        ->load('PoP\\PoP\\', 'src/*');

    /** release workers - in order to execute */
    $releaseWorkersConfig = new ReleaseWorkersConfig();
    foreach ($releaseWorkersConfig->getReleaseWorkerClasses() as $releaseWorkerClass) {
        $services->set($releaseWorkerClass);
    }
};
