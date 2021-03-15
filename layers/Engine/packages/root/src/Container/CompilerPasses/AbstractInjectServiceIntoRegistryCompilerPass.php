<?php

declare(strict_types=1);

namespace PoP\Root\Container\CompilerPasses;

use PoP\Root\Container\ContainerBuilderWrapperInterface;

abstract class AbstractInjectServiceIntoRegistryCompilerPass extends AbstractCompilerPass
{
    protected function doProcess(ContainerBuilderWrapperInterface $containerBuilderWrapper): void
    {
        $registryDefinition = $containerBuilderWrapper->getDefinition($this->getRegistryServiceDefinition());
        $definitions = $containerBuilderWrapper->getDefinitions();
        $serviceClass = $this->getServiceClass();
        foreach ($definitions as $definitionID => $definition) {
            $definitionClass = $definition->getClass();
            if (
                $definitionClass === null
                || !is_a(
                    $definitionClass,
                    $serviceClass,
                    true
                )
            ) {
                continue;
            }

            // Register the service in the corresponding registry
            $registryDefinition->addMethodCall(
                $this->getRegistryMethodCallName(),
                [$this->createReference($definitionID)]
            );
        }
    }

    abstract protected function getRegistryServiceDefinition(): string;
    abstract protected function getServiceClass(): string;
    abstract protected function getRegistryMethodCallName(): string;
}
