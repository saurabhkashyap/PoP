<?php
use PoP\ComponentModel\Misc\RequestUtils;
use PoPCMSSchema\Users\ConditionalOnModule\CustomPosts\Facades\CustomPostUserTypeAPIFacade;
use PoPCMSSchema\Users\Facades\UserTypeAPIFacade;

/**
 * Return the author of the post (to be overriden by Co-Authors plus)
 */
function gdGetPostauthors($post_id)
{
    $customPostUserTypeAPI = CustomPostUserTypeAPIFacade::getInstance();
    return \PoP\Root\App::applyFilters(
    	'gdGetPostauthors',
    	array($customPostUserTypeAPI->getAuthorID($post_id)),
    	$post_id
    );
}

function getAuthorProfileUrl($author)
{
    $userTypeAPI = UserTypeAPIFacade::getInstance();
    $url = $userTypeAPI->getUserURL($author);
    return RequestUtils::addRoute($url, POP_ROUTE_DESCRIPTION);
}

/**
 * Change Author permalink from 'author' to 'u'
 */
\PoP\Root\App::addFilter('author-base', function($authorBase) {
	return 'u';
});
