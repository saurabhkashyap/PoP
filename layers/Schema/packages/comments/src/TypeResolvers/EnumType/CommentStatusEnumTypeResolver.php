<?php

declare(strict_types=1);

namespace PoPSchema\Comments\TypeResolvers\EnumType;

use PoPSchema\Comments\Constants\CommentStatus;
use PoP\ComponentModel\TypeResolvers\EnumType\AbstractEnumTypeResolver;

class CommentStatusEnumTypeResolver extends AbstractEnumTypeResolver
{
    public function getTypeName(): string
    {
        return 'CommentStatus';
    }
    /**
     * @return string[]
     */
    public function getEnumValues(): array
    {
        return [
            CommentStatus::APPROVE,
            CommentStatus::HOLD,
            CommentStatus::SPAM,
            CommentStatus::TRASH,
        ];
    }

    /**
     * Description for a specific enum value
     */
    public function getEnumValueDescription(string $enumValue): ?string
    {
        return match ($enumValue) {
            CommentStatus::APPROVE => $this->translationAPI->__('Approved comment', 'comments'),
            CommentStatus::HOLD => $this->translationAPI->__('Onhold comment', 'comments'),
            CommentStatus::SPAM => $this->translationAPI->__('Spam comment', 'comments'),
            CommentStatus::TRASH => $this->translationAPI->__('Trashed comment', 'comments'),
            default => parent::getEnumValueDescription($enumValue),
        };
    }
}