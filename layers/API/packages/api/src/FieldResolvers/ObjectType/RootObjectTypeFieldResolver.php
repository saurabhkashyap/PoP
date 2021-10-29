<?php

declare(strict_types=1);

namespace PoP\API\FieldResolvers\ObjectType;

use PoP\API\PersistedQueries\PersistedFragmentManagerInterface;
use PoP\API\PersistedQueries\PersistedQueryManagerInterface;
use PoP\API\Schema\SchemaDefinitionServiceInterface;
use PoP\ComponentModel\Cache\PersistentCacheInterface;
use PoP\ComponentModel\Facades\Cache\PersistentCacheFacade;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use PoP\Engine\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use PoPSchema\SchemaCommons\TypeResolvers\ScalarType\JSONObjectScalarTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class RootObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    /**
     * Cannot autowire because its calling `getNamespace`
     * on services.yaml produces an exception of PHP properties not initialized
     * in its depended services.
     */
    protected ?PersistentCacheInterface $persistentCache = null;

    protected ?JSONObjectScalarTypeResolver $jsonObjectScalarTypeResolver = null;
    protected ?PersistedFragmentManagerInterface $fragmentCatalogueManager = null;
    protected ?PersistedQueryManagerInterface $queryCatalogueManager = null;
    protected ?BooleanScalarTypeResolver $booleanScalarTypeResolver = null;

    public function setJSONObjectScalarTypeResolver(JSONObjectScalarTypeResolver $jsonObjectScalarTypeResolver): void
    {
        $this->jsonObjectScalarTypeResolver = $jsonObjectScalarTypeResolver;
    }
    protected function getJSONObjectScalarTypeResolver(): JSONObjectScalarTypeResolver
    {
        return $this->jsonObjectScalarTypeResolver ??= $this->getInstanceManager()->getInstance(JSONObjectScalarTypeResolver::class);
    }
    public function setPersistedFragmentManager(PersistedFragmentManagerInterface $fragmentCatalogueManager): void
    {
        $this->fragmentCatalogueManager = $fragmentCatalogueManager;
    }
    protected function getPersistedFragmentManager(): PersistedFragmentManagerInterface
    {
        return $this->fragmentCatalogueManager ??= $this->getInstanceManager()->getInstance(PersistedFragmentManagerInterface::class);
    }
    public function setPersistedQueryManager(PersistedQueryManagerInterface $queryCatalogueManager): void
    {
        $this->queryCatalogueManager = $queryCatalogueManager;
    }
    protected function getPersistedQueryManager(): PersistedQueryManagerInterface
    {
        return $this->queryCatalogueManager ??= $this->getInstanceManager()->getInstance(PersistedQueryManagerInterface::class);
    }
    public function setBooleanScalarTypeResolver(BooleanScalarTypeResolver $booleanScalarTypeResolver): void
    {
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }
    protected function getBooleanScalarTypeResolver(): BooleanScalarTypeResolver
    {
        return $this->booleanScalarTypeResolver ??= $this->getInstanceManager()->getInstance(BooleanScalarTypeResolver::class);
    }

    //#[Required]
    final public function autowireRootObjectTypeFieldResolver(
        JSONObjectScalarTypeResolver $jsonObjectScalarTypeResolver,
        PersistedFragmentManagerInterface $fragmentCatalogueManager,
        PersistedQueryManagerInterface $queryCatalogueManager,
        BooleanScalarTypeResolver $booleanScalarTypeResolver,
    ): void {
        $this->jsonObjectScalarTypeResolver = $jsonObjectScalarTypeResolver;
        $this->fragmentCatalogueManager = $fragmentCatalogueManager;
        $this->queryCatalogueManager = $queryCatalogueManager;
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }

    final public function getPersistentCache(): PersistentCacheInterface
    {
        $this->persistentCache ??= PersistentCacheFacade::getInstance();
        return $this->persistentCache;
    }

    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            RootObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'fullSchema',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'fullSchema' => $this->getJsonObjectScalarTypeResolver(),
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'fullSchema' => SchemaTypeModifiers::NON_NULLABLE,
            default => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'fullSchema' => $this->getTranslationAPI()->__('The whole API schema, exposing what fields can be queried', 'api'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        switch ($fieldName) {
            case 'fullSchema':
                // Convert from array to stdClass
                /** @var SchemaDefinitionServiceInterface */
                $schemaDefinitionService = $this->getSchemaDefinitionService();
                return (object) $schemaDefinitionService->getFullSchemaDefinition();
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
