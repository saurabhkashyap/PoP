<?php

declare(strict_types=1);

namespace PoPSitesWassup\NotificationMutations\MutationResolvers;

use PoP_Notifications_API;
use PoP\Root\Exception\AbstractException;
use PoP\Root\App;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

abstract class AbstractMarkAsReadOrUnreadNotificationMutationResolver extends AbstractMutationResolver
{
    public function validateErrors(array $form_data): array
    {
        $errors = [];
        $histid = $form_data['histid'];
        if (!$histid) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errors[] = $this->__('This URL is incorrect.', 'pop-notifications');
        } else {
            // $notification = AAL_Main::instance()->api->getNotification($histid);
            $notification = PoP_Notifications_API::getNotification($histid);
            if (!$notification) {
                // @todo Migrate from string to FeedbackItemProvider
                // $errors[] = new FeedbackItemResolution(
                //     MutationErrorFeedbackItemProvider::class,
                //     MutationErrorFeedbackItemProvider::E1,
                // );
                $errors[] = $this->__('This notification does not exist.', 'pop-notifications');
            }
        }
        return $errors;
    }

    protected function additionals($histid, $form_data): void
    {
        App::doAction('GD_NotificationMarkAsReadUnread:additionals', $histid, $form_data);
    }

    abstract protected function getStatus();

    protected function setStatus($form_data)
    {
        // return AAL_Main::instance()->api->setStatus($form_data['histid'], $form_data['user_id'], $this->getStatus());
        return PoP_Notifications_API::setStatus($form_data['histid'], $form_data['user_id'], $this->getStatus());
    }

    /**
     * @param array<string,mixed> $form_data
     * @throws AbstractException In case of error
     */
    public function executeMutation(array $form_data): mixed
    {
        $hist_ids = $this->setStatus($form_data);
        $this->additionals($form_data['histid'], $form_data);

        return $hist_ids; //$form_data['histid'];
    }
}
