<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\Enums;

use PoPSchema\CustomPosts\Types\Status;
use PoP\ComponentModel\Enums\AbstractEnumTypeResolver;

class CustomPostStatusEnum extends AbstractEnumTypeResolver
{
    public function getTypeName(): string
    {
        return 'CustomPostStatus';
    }
    public function getValues(): array
    {
        return [
            Status::PUBLISHED,
            Status::PENDING,
            Status::DRAFT,
            Status::TRASH,
        ];
    }
}
