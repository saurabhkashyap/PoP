<?php

declare(strict_types=1);

namespace PoPSchema\CommentMutations\TypeAPIs;


/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface CommentTypeMutationAPIInterface
{
    public function insertComment(array $comment_data): string | int | Error;
}
