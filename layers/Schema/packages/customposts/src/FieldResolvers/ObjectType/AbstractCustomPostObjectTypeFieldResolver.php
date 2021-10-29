<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\FieldResolvers\ObjectType;

use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\Formatters\DateFormatterInterface;
use PoPSchema\CustomPosts\Enums\CustomPostContentFormatEnum;
use PoPSchema\CustomPosts\FieldResolvers\InterfaceType\IsCustomPostInterfaceTypeFieldResolver;
use PoPSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoPSchema\QueriedObject\FieldResolvers\InterfaceType\QueryableInterfaceTypeFieldResolver;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractCustomPostObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    protected CustomPostTypeAPIInterface $customPostTypeAPI;
    protected DateFormatterInterface $dateFormatter;
    protected QueryableInterfaceTypeFieldResolver $queryableInterfaceTypeFieldResolver;
    protected IsCustomPostInterfaceTypeFieldResolver $isCustomPostInterfaceTypeFieldResolver;

    #[Required]
    final public function autowireAbstractCustomPostObjectTypeFieldResolver(
        CustomPostTypeAPIInterface $customPostTypeAPI,
        DateFormatterInterface $dateFormatter,
        QueryableInterfaceTypeFieldResolver $queryableInterfaceTypeFieldResolver,
        IsCustomPostInterfaceTypeFieldResolver $isCustomPostInterfaceTypeFieldResolver,
    ): void {
        $this->customPostTypeAPI = $customPostTypeAPI;
        $this->dateFormatter = $dateFormatter;
        $this->queryableInterfaceTypeFieldResolver = $queryableInterfaceTypeFieldResolver;
        $this->isCustomPostInterfaceTypeFieldResolver = $isCustomPostInterfaceTypeFieldResolver;
    }

    public function getFieldNamesToResolve(): array
    {
        return [];
    }

    public function getImplementedInterfaceTypeFieldResolvers(): array
    {
        return [
            $this->getQueryableInterfaceTypeFieldResolver(),
            $this->getIsCustomPostInterfaceTypeFieldResolver(),
        ];
    }

    /**
     * Allow to override the implementation service
     */
    protected function getCustomPostTypeAPI(): CustomPostTypeAPIInterface
    {
        return $this->getCustomPostTypeAPI();
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
        $customPostTypeAPI = $this->getCustomPostTypeAPI();
        $customPost = $object;
        switch ($fieldName) {
            case 'url':
                return $customPostTypeAPI->getPermalink($customPost);

            case 'urlPath':
                return $customPostTypeAPI->getPermalinkPath($customPost);

            case 'slug':
                return $customPostTypeAPI->getSlug($customPost);

            case 'content':
                $format = $fieldArgs['format'];
                $value = '';
                if ($format == CustomPostContentFormatEnum::HTML) {
                    $value = $customPostTypeAPI->getContent($customPost);
                } elseif ($format == CustomPostContentFormatEnum::PLAIN_TEXT) {
                    $value = $customPostTypeAPI->getPlainTextContent($customPost);
                }
                return $this->getHooksAPI()->applyFilters(
                    'pop_content',
                    $value,
                    $objectTypeResolver->getID($customPost)
                );

            case 'status':
                return $customPostTypeAPI->getStatus($customPost);

            case 'isStatus':
                return $fieldArgs['status'] == $customPostTypeAPI->getStatus($customPost);

            case 'date':
                return $this->getDateFormatter()->format(
                    $fieldArgs['format'],
                    $customPostTypeAPI->getPublishedDate($customPost, $fieldArgs['gmt'])
                );

            case 'modified':
                return $this->getDateFormatter()->format(
                    $fieldArgs['format'],
                    $customPostTypeAPI->getModifiedDate($customPost, $fieldArgs['gmt'])
                );

            case 'title':
                return $customPostTypeAPI->getTitle($customPost);

            case 'excerpt':
                return $customPostTypeAPI->getExcerpt($customPost);

            case 'customPostType':
                return $customPostTypeAPI->getCustomPostType($customPost);
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
