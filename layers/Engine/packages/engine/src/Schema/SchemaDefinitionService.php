<?php

declare(strict_types=1);

namespace PoP\Engine\Schema;

use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\TypeResolvers\ScalarType\AnyBuiltInScalarScalarTypeResolver;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use PoP\Translation\TranslationAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

class SchemaDefinitionService implements SchemaDefinitionServiceInterface
{
    protected ?RootObjectTypeResolver $rootObjectTypeResolver = null;
    protected ?AnyBuiltInScalarScalarTypeResolver $anyBuiltInScalarScalarTypeResolver = null;
    protected ?InstanceManagerInterface $instanceManager = null;
    protected ?TranslationAPIInterface $translationAPI = null;

    public function setRootObjectTypeResolver(RootObjectTypeResolver $rootObjectTypeResolver): void
    {
        $this->rootObjectTypeResolver = $rootObjectTypeResolver;
    }
    protected function getRootObjectTypeResolver(): RootObjectTypeResolver
    {
        return $this->rootObjectTypeResolver ??= $this->getInstanceManager()->getInstance(RootObjectTypeResolver::class);
    }
    public function setAnyBuiltInScalarScalarTypeResolver(AnyBuiltInScalarScalarTypeResolver $anyBuiltInScalarScalarTypeResolver): void
    {
        $this->anyBuiltInScalarScalarTypeResolver = $anyBuiltInScalarScalarTypeResolver;
    }
    protected function getAnyBuiltInScalarScalarTypeResolver(): AnyBuiltInScalarScalarTypeResolver
    {
        return $this->anyBuiltInScalarScalarTypeResolver ??= $this->getInstanceManager()->getInstance(AnyBuiltInScalarScalarTypeResolver::class);
    }
    public function setInstanceManager(InstanceManagerInterface $instanceManager): void
    {
        $this->instanceManager = $instanceManager;
    }
    protected function getInstanceManager(): InstanceManagerInterface
    {
        return $this->instanceManager ??= $this->getInstanceManager()->getInstance(InstanceManagerInterface::class);
    }
    public function setTranslationAPI(TranslationAPIInterface $translationAPI): void
    {
        $this->translationAPI = $translationAPI;
    }
    protected function getTranslationAPI(): TranslationAPIInterface
    {
        return $this->translationAPI ??= $this->getInstanceManager()->getInstance(TranslationAPIInterface::class);
    }

    //#[Required]
    final public function autowireSchemaDefinitionService(
        RootObjectTypeResolver $rootObjectTypeResolver,
        InstanceManagerInterface $instanceManager,
        AnyBuiltInScalarScalarTypeResolver $anyBuiltInScalarScalarTypeResolver,
        TranslationAPIInterface $translationAPI,
    ): void {
        $this->getRoot()ObjectTypeResolver = $rootObjectTypeResolver;
        $this->instanceManager = $instanceManager;
        $this->anyBuiltInScalarScalarTypeResolver = $anyBuiltInScalarScalarTypeResolver;
        $this->translationAPI = $translationAPI;
    }

    public function getRootObjectTypeResolver(): ObjectTypeResolverInterface
    {
        return $this->getRoot()ObjectTypeResolver;
    }

    /**
     * The `AnyBuiltInScalar` type is a wildcard type,
     * representing any of GraphQL's built-in types
     * (String, Int, Boolean, Float or ID)
     */
    public function getDefaultConcreteTypeResolver(): ConcreteTypeResolverInterface
    {
        return $this->getAnyBuiltInScalarScalarTypeResolver();
    }
    /**
     * The `AnyBuiltInScalar` type is a wildcard type,
     * representing any of GraphQL's built-in types
     * (String, Int, Boolean, Float or ID)
     */
    public function getDefaultInputTypeResolver(): InputTypeResolverInterface
    {
        return $this->getAnyBuiltInScalarScalarTypeResolver();
    }
}
