<?php
use PoP\ComponentModel\FilterInputProcessors\AbstractValueToQueryFilterInputProcessor;

class PoP_Module_Processor_ReferencesFilterInputProcessor extends AbstractValueToQueryFilterInputProcessor
{
    public final const FILTERCOMPONENT_SELECTABLETYPEAHEAD_REFERENCES = 'filtercomponent-selectabletypeahead-references';

    public function getFilterInputsToProcess(): array
    {
        return array(
            [self::class, self::FILTERCOMPONENT_SELECTABLETYPEAHEAD_REFERENCES],
        );
    }

    protected function getQueryArgKey(array $filterInput): string
    {
        switch ($filterInput[1]) {

            case self::FILTERCOMPONENT_SELECTABLETYPEAHEAD_REFERENCES:
                $query['meta-query'][] = [
                    'key' => \PoPCMSSchema\CustomPostMeta\Utils::getMetaKey(GD_METAKEY_POST_REFERENCES),
                    'value' => $value,
                    'compare' => 'IN',
                ];
                break;
        }
    }
}
