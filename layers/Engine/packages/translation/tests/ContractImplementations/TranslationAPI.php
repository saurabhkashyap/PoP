<?php

declare(strict_types=1);

namespace PoP\Translation\ContractImplementations;

class TranslationAPI implements \PoP\Translation\TranslationAPIInterface
{
    public function __(string $text, string $domain = 'default'): string
    {
        return $text;
    }
}
