<?php

declare(strict_types=1);

namespace PoP\Root\Component;

/**
 * Initialize component
 */
interface ComponentInterface
{
    /**
     * Initialize the component
     *
     * @param array<string, mixed> $configuration
     * @param boolean $skipSchema Indicate if to skip initializing the schema
     * @param string[] $skipSchemaComponentClasses
     */
    public function initialize(
        array $configuration = [],
        bool $skipSchema = false,
        array $skipSchemaComponentClasses = []
    ): void;

    /**
     * All component classes that this component depends upon, to initialize them
     *
     * @return string[]
     */
    /**
     * Classes from PoP components that must be initialized before this component
     *
     * @return string[]
     */
    public function getDependedComponentClasses(): array;

    /**
     * All DEV component classes that this component depends upon, to initialize them
     *
     * @return string[]
     */
    public function getDevDependedComponentClasses(): array;

    /**
     * All conditional component classes that this component depends upon, to initialize them
     *
     * @return string[]
     */
    public function getDependedConditionalComponentClasses(): array;

    // /**
    //  * Initialize services
    //  */
    // public static function init(): void;
    /**
     * Function called by the Bootloader after all components have been loaded
     */
    public static function beforeBoot(): void;

    /**
     * Function called by the Bootloader when booting the system
     */
    public static function boot(): void;

    /**
     * Function called by the Bootloader when booting the system
     */
    public static function afterBoot(): void;

    /**
     * Initialize services for the system container
     */
    public function initializeSystem(): void;

    /**
     * Compiler Passes for the System Container
     *
     * @return string[]
     */
    public function getSystemContainerCompilerPassClasses(): array;

     /**
     * Enable each component to set default configuration for
     * itself and its depended components
     *
     * @param array<string, mixed> $componentClassConfiguration
     */
    public function customizeComponentClassConfiguration(
        array &$componentClassConfiguration
    ): void;
}
