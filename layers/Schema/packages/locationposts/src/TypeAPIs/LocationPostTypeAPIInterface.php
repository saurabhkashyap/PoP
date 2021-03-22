<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\TypeAPIs;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface LocationPostTypeAPIInterface
{
    /**
     * Indicates if the passed object is of type LocationPost
     */
    public function isInstanceOfLocationPostType(object $object): bool;
    /**
     * Get the locationPost with provided ID or, if it doesn't exist, null
     */
    public function getLocationPost(mixed $id): ?object;
    /**
     * Indicate if an locationPost with provided ID exists
     */
    public function locationPostExists(mixed $id): bool;
    /**
     * Get the locationPost with provided ID or, if it doesn't exist, null
     */
    public function getLocationPosts($query, array $options = []): array;
}
