<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\BlockAccessors;

use GraphQLAPI\GraphQLAPI\GetterSetterObjects\BlockAttributes\PersistedQueryEndpointGraphiQLBlockAttributes;
use GraphQLAPI\GraphQLAPI\Services\Blocks\PersistedQueryEndpointGraphiQLBlock;
use GraphQLAPI\GraphQLAPI\Services\Helpers\BlockHelpers;
use Symfony\Contracts\Service\Attribute\Required;
use WP_Post;

class PersistedQueryEndpointGraphiQLBlockAccessor
{
    protected BlockHelpers $blockHelpers;
    protected PersistedQueryEndpointGraphiQLBlock $persistedQueryEndpointGraphiQLBlock;

    #[Required]
    final public function autowirePersistedQueryEndpointGraphiQLBlockAccessor(
        BlockHelpers $blockHelpers,
        PersistedQueryEndpointGraphiQLBlock $persistedQueryEndpointGraphiQLBlock,
    ): void {
        $this->blockHelpers = $blockHelpers;
        $this->persistedQueryEndpointGraphiQLBlock = $persistedQueryEndpointGraphiQLBlock;
    }

    /**
     * Extract the Persisted Query Options block attributes from the post
     */
    public function getAttributes(WP_Post $post): ?PersistedQueryEndpointGraphiQLBlockAttributes
    {
        $graphiQLBlock = $this->getBlockHelpers()->getSingleBlockOfTypeFromCustomPost(
            $post,
            $this->getPersistedQueryEndpointGraphiQLBlock()
        );
        // If there is either 0 or more than 1, return nothing
        if ($graphiQLBlock === null) {
            return null;
        }

        $query = $graphiQLBlock['attrs'][PersistedQueryEndpointGraphiQLBlock::ATTRIBUTE_NAME_QUERY] ?? '';
        /**
         * Variables is saved as a string, convert to array.
         *
         * Watch out! If the variables have a wrong format,
         * eg: with an additional trailing comma, such as this:
         *
         *   {
         *     "limit": 3,
         *   }
         *
         * Then doing `json_decode` will return NULL
         */
        $variables = $graphiQLBlock['attrs'][PersistedQueryEndpointGraphiQLBlock::ATTRIBUTE_NAME_VARIABLES] ?? null;
        if ($variables !== null) {
            $variables = json_decode($variables, true) ?? [];
        } else {
            $variables = [];
        }
        return new PersistedQueryEndpointGraphiQLBlockAttributes(
            // Remove whitespaces so it counts as an empty query,
            // so it keeps iterating upwards to get the ancestor query
            // in `getGraphQLQueryPostAttributes`
            trim($query),
            $variables,
        );
    }
}
