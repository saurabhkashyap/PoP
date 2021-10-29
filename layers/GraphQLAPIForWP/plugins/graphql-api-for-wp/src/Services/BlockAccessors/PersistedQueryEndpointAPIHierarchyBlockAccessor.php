<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\BlockAccessors;

use GraphQLAPI\GraphQLAPI\GetterSetterObjects\BlockAttributes\PersistedQueryEndpointAPIHierarchyBlockAttributes;
use GraphQLAPI\GraphQLAPI\Services\Blocks\PersistedQueryEndpointAPIHierarchyBlock;
use GraphQLAPI\GraphQLAPI\Services\Helpers\BlockHelpers;
use Symfony\Contracts\Service\Attribute\Required;
use WP_Post;

class PersistedQueryEndpointAPIHierarchyBlockAccessor
{
    protected BlockHelpers $blockHelpers;
    protected PersistedQueryEndpointAPIHierarchyBlock $persistedQueryEndpointAPIHierarchyBlock;

    #[Required]
    final public function autowirePersistedQueryEndpointAPIHierarchyBlockAccessor(
        BlockHelpers $blockHelpers,
        PersistedQueryEndpointAPIHierarchyBlock $persistedQueryEndpointAPIHierarchyBlock,
    ): void {
        $this->blockHelpers = $blockHelpers;
        $this->persistedQueryEndpointAPIHierarchyBlock = $persistedQueryEndpointAPIHierarchyBlock;
    }

    /**
     * Extract the Persisted Query Options block attributes from the post
     */
    public function getAttributes(WP_Post $post): ?PersistedQueryEndpointAPIHierarchyBlockAttributes
    {
        $apiHierarchyBlock = $this->getBlockHelpers()->getSingleBlockOfTypeFromCustomPost(
            $post,
            $this->getPersistedQueryEndpointAPIHierarchyBlock()
        );
        // If there is either 0 or more than 1, return nothing
        if ($apiHierarchyBlock === null) {
            return null;
        }
        return new PersistedQueryEndpointAPIHierarchyBlockAttributes(
            $apiHierarchyBlock['attrs'][PersistedQueryEndpointAPIHierarchyBlock::ATTRIBUTE_NAME_INHERIT_QUERY] ?? false,
        );
    }
}
