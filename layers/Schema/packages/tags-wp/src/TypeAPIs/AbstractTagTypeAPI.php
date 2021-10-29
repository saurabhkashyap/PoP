<?php

declare(strict_types=1);

namespace PoPSchema\TagsWP\TypeAPIs;

use PoP\Engine\CMS\CMSHelperServiceInterface;
use PoP\Hooks\HooksAPIInterface;
use PoPSchema\SchemaCommons\Constants\QueryOptions;
use PoPSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPSchema\Tags\TypeAPIs\TagTypeAPIInterface;
use PoPSchema\TaxonomiesWP\TypeAPIs\TaxonomyTypeAPI;
use Symfony\Contracts\Service\Attribute\Required;
use WP_Taxonomy;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
abstract class AbstractTagTypeAPI extends TaxonomyTypeAPI implements TagTypeAPIInterface
{
    public const HOOK_QUERY = __CLASS__ . ':query';

    protected HooksAPIInterface $hooksAPI;
    protected CMSHelperServiceInterface $cmsHelperService;

    #[Required]
    final public function autowireAbstractTagTypeAPI(HooksAPIInterface $hooksAPI, CMSHelperServiceInterface $cmsHelperService): void
    {
        $this->hooksAPI = $hooksAPI;
        $this->cmsHelperService = $cmsHelperService;
    }

    abstract protected function getTagTaxonomyName(): string;


    /**
     * Indicates if the passed object is of type Tag
     */
    public function isInstanceOfTagType(object $object): bool
    {
        return ($object instanceof WP_Taxonomy) && $object->hierarchical == false;
    }

    protected function getTagFromObjectOrID(string | int | object $tagObjectOrID): object
    {
        return is_object($tagObjectOrID) ?
            $tagObjectOrID
            : \get_term($tagObjectOrID, $this->getTagTaxonomyName());
    }
    public function getTagName(string | int | object $tagObjectOrID): string
    {
        $tag = $this->getTagFromObjectOrID($tagObjectOrID);
        return $tag->name;
    }
    public function getTag(string | int $tagID): object
    {
        return get_tag($tagID, $this->getTagTaxonomyName());
    }
    public function getTagByName(string $tagName): object
    {
        return get_term_by('name', $tagName, $this->getTagTaxonomyName());
    }
    public function getCustomPostTags(string | int $customPostID, array $query = [], array $options = []): array
    {
        $query = $this->convertTagsQuery($query, $options);

        return \wp_get_post_terms($customPostID, $this->getTagTaxonomyName(), $query);
    }
    public function getCustomPostTagCount(string | int $customPostID, array $query = [], array $options = []): int
    {
        // There is no direct way to calculate the total
        // (Documentation mentions to pass arg "count" => `true` to `wp_get_post_tags`,
        // but it doesn't work)
        // So execute a normal `wp_get_post_tags` retrieving all the IDs, and count them
        $options[QueryOptions::RETURN_TYPE] = ReturnTypes::IDS;
        $query = $this->convertTagsQuery($query, $options);

        // All results, no offset
        $query['number'] = 0;
        unset($query['offset']);

        // Resolve and count
        $tags = \wp_get_post_terms($customPostID, $this->getTagTaxonomyName(), $query);
        return count($tags);
    }
    public function getTagCount(array $query = [], array $options = []): int
    {
        $query = $this->convertTagsQuery($query, $options);

        // Indicate to return the count
        $query['count'] = true;
        $query['fields'] = 'count';

        // All results, no offset
        $query['number'] = 0;
        unset($query['offset']);

        // Execute query and return count
        /** @var int[] */
        $count = \get_tags($query);
        // For some reason, the count is returned as an array of 1 element!
        if (is_array($count) && count($count) === 1 && is_numeric($count[0])) {
            return (int) $count[0];
        }
        // An error happened
        return -1;
    }
    public function getTags(array $query, array $options = []): array
    {
        $query = $this->convertTagsQuery($query, $options);
        return get_tags($query);
    }

    public function convertTagsQuery(array $query, array $options = []): array
    {
        $query['taxonomy'] = $this->getTagTaxonomyName();

        if ($return_type = $options[QueryOptions::RETURN_TYPE] ?? null) {
            if ($return_type === ReturnTypes::IDS) {
                $query['fields'] = 'ids';
            } elseif ($return_type === ReturnTypes::NAMES) {
                $query['fields'] = 'names';
            }
        }

        if (isset($query['hide-empty'])) {
            $query['hide_empty'] = $query['hide-empty'];
            unset($query['hide-empty']);
        } else {
            // By default: do not hide empty tags
            $query['hide_empty'] = false;
        }

        // Convert the parameters
        if (isset($query['include']) && is_array($query['include'])) {
            // It can be an array or a string
            $query['include'] = implode(',', $query['include']);
        }
        if (isset($query['exclude-ids'])) {
            $query['exclude'] = $query['exclude-ids'];
            unset($query['exclude-ids']);
        }
        if (isset($query['order'])) {
            // Same param name, so do nothing
        }
        if (isset($query['orderby'])) {
            // Same param name, so do nothing
            // This param can either be a string or an array. Eg:
            // $query['orderby'] => array('date' => 'DESC', 'title' => 'ASC');
        }
        if (isset($query['offset'])) {
            // Same param name, so do nothing
        }
        if (isset($query['limit'])) {
            $limit = (int) $query['limit'];
            // To bring all results, get_tags needs "number => 0" instead of -1
            $query['number'] = ($limit == -1) ? 0 : $limit;
            unset($query['limit']);
        }
        if (isset($query['search'])) {
            // Same param name, so do nothing
        }
        if (isset($query['slugs'])) {
            $query['slug'] = $query['slugs'];
            unset($query['slugs']);
        }
        if (isset($query['slug'])) {
            // Same param name, so do nothing
        }

        return $this->getHooksAPI()->applyFilters(
            TaxonomyTypeAPI::HOOK_QUERY,
            $this->getHooksAPI()->applyFilters(
                self::HOOK_QUERY,
                $query,
                $options
            ),
            $query,
            $options
        );
    }
    public function getTagURL(string | int | object $tagObjectOrID): string
    {
        return get_term_link($tagObjectOrID, $this->getTagTaxonomyName());
    }

    public function getTagURLPath(string | int | object $tagObjectOrID): string
    {
        /** @var string */
        return $this->getCmsHelperService()->getLocalURLPath($this->getTagURL($tagObjectOrID));
    }

    public function getTagSlug(string | int | object $tagObjectOrID): string
    {
        $tag = $this->getTagFromObjectOrID($tagObjectOrID);
        return $tag->slug;
    }
    public function getTagDescription(string | int | object $tagObjectOrID): string
    {
        $tag = $this->getTagFromObjectOrID($tagObjectOrID);
        return $tag->description;
    }
    public function getTagItemCount(string | int | object $tagObjectOrID): int
    {
        $tag = $this->getTagFromObjectOrID($tagObjectOrID);
        return $tag->count;
    }
    public function getTagID(object $tag): string | int
    {
        return $tag->term_id;
    }
}
