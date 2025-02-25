<?php
use PoP\ComponentModel\FilterInputs\AbstractValueToQueryFilterInput;

class PoP_Events_Module_Processor_FilterInput extends AbstractValueToQueryFilterInput
{
    public final const FILTERINPUT_EVENTSCOPE = 'filterinput-eventscope';

    public function getFilterInputsToProcess(): array
    {
        return array(
            [self::class, self::FILTERINPUT_EVENTSCOPE],
        );
    }

    /**
     * @todo Split this class into multiple ones, returning a single string per each ($filterInput is not valid anymore)
     */
    protected function getQueryArgKey(): string
    {
        switch ($filterInput[1]) {
            case self::FILTERINPUT_EVENTSCOPE:
                $query['scope'] = $value['from'].','.$value['to'];
                break;
        }
    }
}



