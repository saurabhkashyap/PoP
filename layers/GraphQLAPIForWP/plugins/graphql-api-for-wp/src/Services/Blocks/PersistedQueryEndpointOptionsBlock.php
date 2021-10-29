<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks;

use GraphQLAPI\GraphQLAPI\Services\BlockCategories\BlockCategoryInterface;
use GraphQLAPI\GraphQLAPI\Services\BlockCategories\PersistedQueryEndpointBlockCategory;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Persisted Query Options block
 */
class PersistedQueryEndpointOptionsBlock extends AbstractEndpointOptionsBlock implements PersistedQueryEndpointEditorBlockServiceTagInterface
{
    use MainPluginBlockTrait;

    public const ATTRIBUTE_NAME_ACCEPT_VARIABLES_AS_URL_PARAMS = 'acceptVariablesAsURLParams';

    protected PersistedQueryEndpointBlockCategory $persistedQueryEndpointBlockCategory;

    #[Required]
    final public function autowirePersistedQueryEndpointOptionsBlock(
        PersistedQueryEndpointBlockCategory $persistedQueryEndpointBlockCategory,
    ): void {
        $this->persistedQueryEndpointBlockCategory = $persistedQueryEndpointBlockCategory;
    }

    protected function getBlockName(): string
    {
        return 'persisted-query-endpoint-options';
    }

    public function getBlockPriority(): int
    {
        return 160;
    }

    /**
     * Add the locale language to the localized data?
     */
    protected function addLocalLanguage(): bool
    {
        return true;
    }

    /**
     * Default language for the script/component's documentation
     */
    protected function getDefaultLanguage(): ?string
    {
        // English
        return 'en';
    }

    protected function getBlockCategory(): ?BlockCategoryInterface
    {
        return $this->getPersistedQueryEndpointBlockCategory();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    protected function getBlockContent(array $attributes, string $content): string
    {
        $blockContent = parent::getBlockContent($attributes, $content);

        $blockContentPlaceholder = '<p><strong>%s</strong></p><p>%s</p>';
        $blockContent .= sprintf(
            $blockContentPlaceholder,
            \__('Accept variables as URL params:', 'graphql-api'),
            $this->getBooleanLabel($attributes[self::ATTRIBUTE_NAME_ACCEPT_VARIABLES_AS_URL_PARAMS] ?? true)
        );

        return $blockContent;
    }
}
