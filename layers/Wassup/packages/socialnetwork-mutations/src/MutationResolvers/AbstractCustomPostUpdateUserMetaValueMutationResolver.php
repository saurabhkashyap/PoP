<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolvers;

use PoP\Hooks\HooksAPIInterface;
use PoP\Translation\TranslationAPIInterface;
use PoPSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoPSchema\Posts\Constants\InputNames;

class AbstractCustomPostUpdateUserMetaValueMutationResolver extends AbstractUpdateUserMetaValueMutationResolver
{
    protected CustomPostTypeAPIInterface $customPostTypeAPI;
    public function __construct(
        TranslationAPIInterface $translationAPI,
        HooksAPIInterface $hooksAPI,
        CustomPostTypeAPIInterface $customPostTypeAPI,
    ) {
        $this->customPostTypeAPI = $customPostTypeAPI;
        parent::__construct(
            $translationAPI,
            $hooksAPI,
        );
    }

    protected function eligible($post)
    {
        return true;
    }

    public function validateErrors(array $form_data): ?array
    {
        $errors = parent::validateErrors($form_data);
        if (!$errors) {
            $target_id = $form_data['target_id'];

            // Make sure the post exists
            $target = $this->customPostTypeAPI->getCustomPost($target_id);
            if (!$target) {
                $errors[] = $this->translationAPI->__('The requested post does not exist.', 'pop-coreprocessors');
            } else {
                // Make sure this target accepts this functionality. Eg: Not all posts can be Recommended or Up/Down-voted.
                // Discussion can be recommended only, Highlight up/down-voted only
                if (!$this->eligible($target)) {
                    $errors[] = $this->translationAPI->__('The requested functionality does not apply on this post.', 'pop-coreprocessors');
                }
            }
        }
        return $errors;
    }

    protected function getRequestKey()
    {
        return InputNames::POST_ID;
    }

    protected function additionals($target_id, $form_data)
    {
        $this->hooksAPI->doAction('gd_updateusermetavalue:post', $target_id, $form_data);
        parent::additionals($target_id, $form_data);
    }
}
