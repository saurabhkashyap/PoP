<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\CustomPostTypes;

use GraphQLAPI\GraphQLAPI\ComponentConfiguration;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\EndpointFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\Registries\BlockRegistryInterface;
use GraphQLAPI\GraphQLAPI\Registries\CustomEndpointAnnotatorRegistryInterface;
use GraphQLAPI\GraphQLAPI\Registries\CustomEndpointExecuterRegistryInterface;
use GraphQLAPI\GraphQLAPI\Registries\EndpointAnnotatorRegistryInterface;
use GraphQLAPI\GraphQLAPI\Registries\EndpointBlockRegistryInterface;
use GraphQLAPI\GraphQLAPI\Registries\EndpointExecuterRegistryInterface;
use GraphQLAPI\GraphQLAPI\Services\Blocks\BlockInterface;
use GraphQLAPI\GraphQLAPI\Services\Blocks\CustomEndpointOptionsBlock;
use GraphQLAPI\GraphQLAPI\Services\Taxonomies\GraphQLQueryTaxonomy;
use Symfony\Contracts\Service\Attribute\Required;

class GraphQLCustomEndpointCustomPostType extends AbstractGraphQLEndpointCustomPostType
{
    use WithBlockRegistryCustomPostTypeTrait;

    protected ?EndpointBlockRegistryInterface $endpointBlockRegistry = null;
    protected ?CustomEndpointExecuterRegistryInterface $customEndpointExecuterRegistryInterface = null;
    protected ?CustomEndpointAnnotatorRegistryInterface $customEndpointAnnotatorRegistryInterface = null;
    protected ?CustomEndpointOptionsBlock $customEndpointOptionsBlock = null;

    public function setEndpointBlockRegistry(EndpointBlockRegistryInterface $endpointBlockRegistry): void
    {
        $this->endpointBlockRegistry = $endpointBlockRegistry;
    }
    protected function getEndpointBlockRegistry(): EndpointBlockRegistryInterface
    {
        return $this->endpointBlockRegistry ??= $this->getInstanceManager()->getInstance(EndpointBlockRegistryInterface::class);
    }
    public function setCustomEndpointExecuterRegistry(CustomEndpointExecuterRegistryInterface $customEndpointExecuterRegistryInterface): void
    {
        $this->customEndpointExecuterRegistryInterface = $customEndpointExecuterRegistryInterface;
    }
    protected function getCustomEndpointExecuterRegistry(): CustomEndpointExecuterRegistryInterface
    {
        return $this->customEndpointExecuterRegistryInterface ??= $this->getInstanceManager()->getInstance(CustomEndpointExecuterRegistryInterface::class);
    }
    public function setCustomEndpointAnnotatorRegistry(CustomEndpointAnnotatorRegistryInterface $customEndpointAnnotatorRegistryInterface): void
    {
        $this->customEndpointAnnotatorRegistryInterface = $customEndpointAnnotatorRegistryInterface;
    }
    protected function getCustomEndpointAnnotatorRegistry(): CustomEndpointAnnotatorRegistryInterface
    {
        return $this->customEndpointAnnotatorRegistryInterface ??= $this->getInstanceManager()->getInstance(CustomEndpointAnnotatorRegistryInterface::class);
    }
    public function setCustomEndpointOptionsBlock(CustomEndpointOptionsBlock $customEndpointOptionsBlock): void
    {
        $this->customEndpointOptionsBlock = $customEndpointOptionsBlock;
    }
    protected function getCustomEndpointOptionsBlock(): CustomEndpointOptionsBlock
    {
        return $this->customEndpointOptionsBlock ??= $this->getInstanceManager()->getInstance(CustomEndpointOptionsBlock::class);
    }

    //#[Required]
    final public function autowireGraphQLCustomEndpointCustomPostType(
        EndpointBlockRegistryInterface $endpointBlockRegistry,
        CustomEndpointExecuterRegistryInterface $customEndpointExecuterRegistryInterface,
        CustomEndpointAnnotatorRegistryInterface $customEndpointAnnotatorRegistryInterface,
        CustomEndpointOptionsBlock $customEndpointOptionsBlock,
    ): void {
        $this->endpointBlockRegistry = $endpointBlockRegistry;
        $this->customEndpointExecuterRegistryInterface = $customEndpointExecuterRegistryInterface;
        $this->customEndpointAnnotatorRegistryInterface = $customEndpointAnnotatorRegistryInterface;
        $this->customEndpointOptionsBlock = $customEndpointOptionsBlock;
    }

    /**
     * Custom Post Type name
     */
    public function getCustomPostType(): string
    {
        return 'graphql-endpoint';
    }

    /**
     * Module that enables this PostType
     */
    public function getEnablingModule(): ?string
    {
        return EndpointFunctionalityModuleResolver::CUSTOM_ENDPOINTS;
    }

    /**
     * The position on which to add the CPT on the menu.
     */
    protected function getMenuPosition(): int
    {
        return 1;
    }

    /**
     * Access endpoints under /graphql, or wherever it is configured to
     */
    protected function getSlugBase(): ?string
    {
        return ComponentConfiguration::getCustomEndpointSlugBase();
    }

    /**
     * Custom post type name
     */
    public function getCustomPostTypeName(): string
    {
        return \__('GraphQL custom endpoint', 'graphql-api');
    }

    /**
     * Custom Post Type plural name
     *
     * @param bool $uppercase Indicate if the name must be uppercase (for starting a sentence) or, otherwise, lowercase
     */
    protected function getCustomPostTypePluralNames(bool $uppercase): string
    {
        return \__('GraphQL endpoints', 'graphql-api');
    }

    /**
     * Labels for registering the post type
     *
     * @param string $name_uc Singular name uppercase
     * @param string $names_uc Plural name uppercase
     * @param string $names_lc Plural name lowercase
     * @return array<string, string>
     */
    protected function getCustomPostTypeLabels(string $name_uc, string $names_uc, string $names_lc): array
    {
        /**
         * Because the name is too long, shorten it for the admin menu only
         */
        return array_merge(
            parent::getCustomPostTypeLabels($name_uc, $names_uc, $names_lc),
            array(
                'all_items' => \__('Custom Endpoints', 'graphql-api'),
            )
        );
    }

    /**
     * The Query is publicly accessible, and the permalink must be configurable
     */
    protected function isPublic(): bool
    {
        return true;
    }

    /**
     * Taxonomies
     *
     * @return string[]
     */
    protected function getTaxonomies(): array
    {
        return [
            GraphQLQueryTaxonomy::TAXONOMY_CATEGORY,
        ];
    }

    /**
     * Hierarchical
     */
    protected function isHierarchical(): bool
    {
        return true;
    }

    protected function getBlockRegistry(): BlockRegistryInterface
    {
        return $this->getEndpointBlockRegistry();
    }

    /**
     * Indicate if the excerpt must be used as the CPT's description and rendered when rendering the post
     */
    public function usePostExcerptAsDescription(): bool
    {
        return true;
    }

    /**
     * Label to show on the "execute" action in the CPT table
     */
    protected function getExecuteActionLabel(): string
    {
        return __('View endpoint', 'graphql-api');
    }

    public function getEndpointOptionsBlock(): BlockInterface
    {
        return $this->getCustomEndpointOptionsBlock();
    }

    protected function getEndpointExecuterRegistry(): EndpointExecuterRegistryInterface
    {
        return $this->getCustomEndpointExecuterRegistryInterface();
    }

    protected function getEndpointAnnotatorRegistry(): EndpointAnnotatorRegistryInterface
    {
        return $this->getCustomEndpointAnnotatorRegistryInterface();
    }
}
