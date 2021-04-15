<?php

declare(strict_types=1);

namespace PoPSchema\Posts\Conditional\Users\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoPSchema\Posts\FieldResolvers\AbstractPostFieldResolver;
use PoPSchema\Users\TypeResolvers\UserTypeResolver;

class PostUserFieldResolver extends AbstractPostFieldResolver
{
    public function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'posts' => $translationAPI->__('Posts by the user', 'users'),
            'postCount' => $translationAPI->__('Number of posts by the user', 'users'),
            'unrestrictedPosts' => $translationAPI->__('[Admin] Posts by the user', 'users'),
            'unrestrictedPostCount' => $translationAPI->__('[Admin] Number of posts by the user', 'users'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @return array<string, mixed>
     */
    protected function getQuery(
        TypeResolverInterface $typeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = []
    ): array {
        $query = parent::getQuery($typeResolver, $resultItem, $fieldName, $fieldArgs);

        $user = $resultItem;
        switch ($fieldName) {
            case 'posts':
            case 'postCount':
            case 'unrestrictedPosts':
            case 'unrestrictedPostCount':
                $query['authors'] = [$typeResolver->getID($user)];
                break;
        }

        return $query;
    }
}
