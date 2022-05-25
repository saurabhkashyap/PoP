<?php

declare(strict_types=1);

namespace PoPCMSSchema\Media\FilterInputProcessors;

use PoP\ComponentModel\FilterInputProcessors\AbstractValueToQueryFilterInputProcessor;

class FilterInputProcessor extends AbstractValueToQueryFilterInputProcessor
{
    public final const FILTERINPUT_MIME_TYPES = 'filterinput-mime-types';

    public function getFilterInputsToProcess(): array
    {
        return array(
            [self::class, self::FILTERINPUT_MIME_TYPES],
        );
    }

    protected function getQueryArgKey(array $filterInput): string
    {
        switch ($filterInput[1]) {
            case self::FILTERINPUT_MIME_TYPES:
                $query['mime-types'] = $value;
                break;
        }
    }
}
