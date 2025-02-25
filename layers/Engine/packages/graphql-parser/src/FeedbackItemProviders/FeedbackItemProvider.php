<?php

declare(strict_types=1);

namespace PoP\GraphQLParser\FeedbackItemProviders;

use PoP\Root\FeedbackItemProviders\AbstractFeedbackItemProvider;
use PoP\Root\Feedback\FeedbackCategories;

class FeedbackItemProvider extends AbstractFeedbackItemProvider
{
    public final const E1 = '1';
    public final const E2 = '2';

    /**
     * @return string[]
     */
    public function getCodes(): array
    {
        return [
            self::E1,
            self::E2,
        ];
    }

    public function getMessagePlaceholder(string $code): string
    {
        return match ($code) {
            self::E1 => $this->__('Before executing `%s`, must call `validateAndInitialize`', 'graphql-server'),
            self::E2 => $this->__('Context has not been set for variable \'%s\'', 'graphql-server'),
            default => parent::getMessagePlaceholder($code),
        };
    }

    public function getCategory(string $code): string
    {
        return match ($code) {
            self::E1,
            self::E2
                => FeedbackCategories::ERROR,
            default => parent::getCategory($code),
        };
    }
}
