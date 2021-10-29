<?php

declare(strict_types=1);

namespace PoP\ComponentModel\TypeResolvers;

use PoP\ComponentModel\AttachableExtensions\AttachableExtensionManagerInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\Schema\SchemaDefinitionServiceInterface;
use PoP\ComponentModel\Schema\SchemaNamespacingServiceInterface;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Hooks\HooksAPIInterface;
use PoP\Translation\TranslationAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractTypeResolver implements TypeResolverInterface
{
    /**
     * @var array<string, array>
     */
    protected ?array $schemaDefinition = null;

    protected ?TranslationAPIInterface $translationAPI = null;
    protected ?HooksAPIInterface $hooksAPI = null;
    protected ?InstanceManagerInterface $instanceManager = null;
    protected ?SchemaNamespacingServiceInterface $schemaNamespacingService = null;
    protected ?SchemaDefinitionServiceInterface $schemaDefinitionService = null;
    protected ?AttachableExtensionManagerInterface $attachableExtensionManager = null;

    public function setTranslationAPI(TranslationAPIInterface $translationAPI): void
    {
        $this->translationAPI = $translationAPI;
    }
    protected function getTranslationAPI(): TranslationAPIInterface
    {
        return $this->translationAPI ??= $this->getInstanceManager()->getInstance(TranslationAPIInterface::class);
    }
    public function setHooksAPI(HooksAPIInterface $hooksAPI): void
    {
        $this->hooksAPI = $hooksAPI;
    }
    protected function getHooksAPI(): HooksAPIInterface
    {
        return $this->hooksAPI ??= $this->getInstanceManager()->getInstance(HooksAPIInterface::class);
    }
    public function setInstanceManager(InstanceManagerInterface $instanceManager): void
    {
        $this->instanceManager = $instanceManager;
    }
    protected function getInstanceManager(): InstanceManagerInterface
    {
        return $this->instanceManager ??= $this->getInstanceManager()->getInstance(InstanceManagerInterface::class);
    }
    public function setSchemaNamespacingService(SchemaNamespacingServiceInterface $schemaNamespacingService): void
    {
        $this->schemaNamespacingService = $schemaNamespacingService;
    }
    protected function getSchemaNamespacingService(): SchemaNamespacingServiceInterface
    {
        return $this->schemaNamespacingService ??= $this->getInstanceManager()->getInstance(SchemaNamespacingServiceInterface::class);
    }
    public function setSchemaDefinitionService(SchemaDefinitionServiceInterface $schemaDefinitionService): void
    {
        $this->schemaDefinitionService = $schemaDefinitionService;
    }
    protected function getSchemaDefinitionService(): SchemaDefinitionServiceInterface
    {
        return $this->schemaDefinitionService ??= $this->getInstanceManager()->getInstance(SchemaDefinitionServiceInterface::class);
    }
    public function setAttachableExtensionManager(AttachableExtensionManagerInterface $attachableExtensionManager): void
    {
        $this->attachableExtensionManager = $attachableExtensionManager;
    }
    protected function getAttachableExtensionManager(): AttachableExtensionManagerInterface
    {
        return $this->attachableExtensionManager ??= $this->getInstanceManager()->getInstance(AttachableExtensionManagerInterface::class);
    }

    //#[Required]
    final public function autowireAbstractTypeResolver(TranslationAPIInterface $translationAPI, HooksAPIInterface $hooksAPI, InstanceManagerInterface $instanceManager, SchemaNamespacingServiceInterface $schemaNamespacingService, SchemaDefinitionServiceInterface $schemaDefinitionService, AttachableExtensionManagerInterface $attachableExtensionManager): void
    {
        $this->translationAPI = $translationAPI;
        $this->hooksAPI = $hooksAPI;
        $this->instanceManager = $instanceManager;
        $this->schemaNamespacingService = $schemaNamespacingService;
        $this->schemaDefinitionService = $schemaDefinitionService;
        $this->attachableExtensionManager = $attachableExtensionManager;
    }

    public function getNamespace(): string
    {
        return $this->getSchemaNamespacingService()->getSchemaNamespace(get_called_class());
    }

    final public function getNamespacedTypeName(): string
    {
        return $this->getSchemaNamespacingService()->getSchemaNamespacedName(
            $this->getNamespace(),
            $this->getTypeName()
        );
    }

    final public function getMaybeNamespacedTypeName(): string
    {
        $vars = ApplicationState::getVars();
        return $vars['namespace-types-and-interfaces'] ?
            $this->getNamespacedTypeName() :
            $this->getTypeName();
    }

    final public function getTypeOutputDBKey(): string
    {
        // Do not make the first letter lowercase, or namespaced names look bad
        return $this->getMaybeNamespacedTypeName();
    }

    public function getTypeDescription(): ?string
    {
        return null;
    }
}
