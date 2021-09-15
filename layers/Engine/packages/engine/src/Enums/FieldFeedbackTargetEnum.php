<?php

declare(strict_types=1);

namespace PoP\Engine\Enums;

use PoP\ComponentModel\Enums\AbstractEnumTypeResolver;

class FieldFeedbackTargetEnum extends AbstractEnumTypeResolver
{
    public const DB = 'db';
    public const SCHEMA = 'schema';

    public function getTypeName(): string
    {
        return 'FieldFeedbackTarget';
    }
    public function getValues(): array
    {
        return [
            self::DB,
            self::SCHEMA,
        ];
    }
}
