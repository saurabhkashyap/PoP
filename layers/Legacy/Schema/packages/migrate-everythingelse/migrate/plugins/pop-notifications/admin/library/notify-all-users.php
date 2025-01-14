<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\Root\App;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

/**
 * Object type: 'Post'
 * Action: Notify all users functionality
 * Allow to notify all users of a given post, by setting the object_name in the textarea
 */

define('AAL_POP_NOTIFYALLUSERS_NONCE', 'aal_pop_notifyallusers');

/**
 * Allows to add the System Notification to the post in the Backend
 */
\PoP\Root\App::addAction('admin_init', 'aalPopNotifyallusersAddMetaBox');
function aalPopNotifyallusersAddMetaBox()
{

    // Enable if the current logged in user is the System Notification's defined user
    if (\PoP\Root\App::getState('current-user-id') != POP_NOTIFICATIONS_USERPLACEHOLDER_SYSTEMNOTIFICATIONS) {
        return;
    }

    $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
    $screens = $cmsapplicationpostsapi->getAllcontentPostTypes();
    foreach ($screens as $screen) {
        // Add in the Post
        add_meta_box(
            'aal_pop_notifyallusers',
            TranslationAPIFacade::getInstance()->__('Activity Log / User Notification', 'pop-notifications'),
            'aalPopNotifyallusersMetaBoxContent',
            $screen,
            'normal',
            'low'
        );
    }
}

function aalPopNotifyallusersMetaBoxContent()
{

    // Enable if the current logged in user is the System Notification's defined user
    if (\PoP\Root\App::getState('current-user-id') != POP_NOTIFICATIONS_USERPLACEHOLDER_SYSTEMNOTIFICATIONS) {
        return;
    }

    wp_nonce_field(AAL_POP_NOTIFYALLUSERS_NONCE, 'aal_pop_notifyallusers_nonce');

    $submitted = ('POST' === \PoP\Root\App::server('REQUEST_METHOD'));
    if ($submitted) {
        $notification = App::request('aal_pop_notifyallusers', '');
    }

    _e('Notify all users: enter a message to link to this post:', 'pop-notifications');
    print(
    '<br/>'.
    '<textarea name="aal_pop_notifyallusers" rows="5" style="width: 100%;">'.
    $notification.
    '</textarea>'
    );
}


\PoP\Root\App::addAction(
    'popcms:savePost',
    'aalPopNotifyallusersMetaBoxSave'
);
function aalPopNotifyallusersMetaBoxSave($post_id)
{

    // Enable if the current logged in user is the System Notification's defined user
    if (\PoP\Root\App::getState('current-user-id') != POP_NOTIFICATIONS_USERPLACEHOLDER_SYSTEMNOTIFICATIONS) {
        return;
    }

    if (@!wp_verify_nonce(App::request('aal_pop_notifyallusers_nonce', ''), AAL_POP_NOTIFYALLUSERS_NONCE)) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ($notification = trim(App::request('aal_pop_notifyallusers', ''))) {
        PoP_Notifications_Utils::notifyAllUsers($post_id, $notification);
    }
}
