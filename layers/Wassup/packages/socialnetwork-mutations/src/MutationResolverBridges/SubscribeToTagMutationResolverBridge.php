<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\SubscribeToTagMutationResolver;
use PoPSchema\PostTags\Facades\PostTagTypeAPIFacade;

class SubscribeToTagMutationResolverBridge extends AbstractTagUpdateUserMetaValueMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return SubscribeToTagMutationResolver::class;
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        $applicationtaxonomyapi = \PoP\ApplicationTaxonomies\FunctionAPIFactory::getInstance();
        $postTagTypeAPI = PostTagTypeAPIFacade::getInstance();
        $tag = $postTagTypeAPI->getTag($result_id);
        return sprintf(
            TranslationAPIFacade::getInstance()->__('You have subscribed to <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $applicationtaxonomyapi->getTagSymbolName($tag)
        );
    }
}
