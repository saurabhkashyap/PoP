<?php

declare(strict_types=1);

namespace PoPCMSSchema\CustomPosts\ComponentProcessors;

use PoPCMSSchema\CustomPosts\ComponentProcessors\FormInputs\FilterInputComponentProcessor;
use PoPCMSSchema\SchemaCommons\ComponentProcessors\FormInputs\CommonFilterInputComponentProcessor;

class CustomPostFilterInputContainerComponentProcessor extends AbstractCustomPostFilterInputContainerComponentProcessor
{
    public const HOOK_FILTER_INPUTS = __CLASS__ . ':filter-inputs';

    public final const MODULE_FILTERINPUTCONTAINER_UNIONCUSTOMPOSTLIST = 'filterinputcontainer-unioncustompostlist';
    public final const MODULE_FILTERINPUTCONTAINER_UNIONCUSTOMPOSTCOUNT = 'filterinputcontainer-unioncustompostcount';
    public final const MODULE_FILTERINPUTCONTAINER_ADMINUNIONCUSTOMPOSTLIST = 'filterinputcontainer-adminunioncustompostlist';
    public final const MODULE_FILTERINPUTCONTAINER_ADMINUNIONCUSTOMPOSTCOUNT = 'filterinputcontainer-adminunioncustompostcount';
    public final const MODULE_FILTERINPUTCONTAINER_CUSTOMPOSTLISTLIST = 'filterinputcontainer-custompostlist';
    public final const MODULE_FILTERINPUTCONTAINER_CUSTOMPOSTLISTCOUNT = 'filterinputcontainer-custompostcount';
    public final const MODULE_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTLIST = 'filterinputcontainer-admincustompostlist';
    public final const MODULE_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTCOUNT = 'filterinputcontainer-admincustompostcount';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FILTERINPUTCONTAINER_UNIONCUSTOMPOSTLIST],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_UNIONCUSTOMPOSTCOUNT],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_ADMINUNIONCUSTOMPOSTLIST],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_ADMINUNIONCUSTOMPOSTCOUNT],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOSTLISTLIST],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOSTLISTCOUNT],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTLIST],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTCOUNT],
        );
    }

    public function getFilterInputModules(array $componentVariation): array
    {
        $customPostFilterInputModules = [
            ...$this->getIDFilterInputModules(),
            [CommonFilterInputComponentProcessor::class, CommonFilterInputComponentProcessor::MODULE_FILTERINPUT_SEARCH],
        ];
        $unionCustomPostFilterInputModules = [
            [FilterInputComponentProcessor::class, FilterInputComponentProcessor::MODULE_FILTERINPUT_UNIONCUSTOMPOSTTYPES],
        ];
        $adminCustomPostFilterInputModules = [
            [FilterInputComponentProcessor::class, FilterInputComponentProcessor::MODULE_FILTERINPUT_CUSTOMPOSTSTATUS],
        ];
        $paginationFilterInputModules = $this->getPaginationFilterInputModules();
        return match ($componentVariation[1]) {
            self::MODULE_FILTERINPUTCONTAINER_UNIONCUSTOMPOSTLIST => [
                ...$customPostFilterInputModules,
                ...$unionCustomPostFilterInputModules,
                ...$paginationFilterInputModules,
            ],
            self::MODULE_FILTERINPUTCONTAINER_ADMINUNIONCUSTOMPOSTLIST => [
                ...$customPostFilterInputModules,
                ...$unionCustomPostFilterInputModules,
                ...$adminCustomPostFilterInputModules,
                ...$paginationFilterInputModules,
            ],
            self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOSTLISTLIST => [
                ...$customPostFilterInputModules,
                ...$paginationFilterInputModules,
            ],
            self::MODULE_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTLIST => [
                ...$customPostFilterInputModules,
                ...$adminCustomPostFilterInputModules,
                ...$paginationFilterInputModules,
            ],
            self::MODULE_FILTERINPUTCONTAINER_UNIONCUSTOMPOSTCOUNT => [
                ...$customPostFilterInputModules,
                ...$unionCustomPostFilterInputModules,
            ],
            self::MODULE_FILTERINPUTCONTAINER_ADMINUNIONCUSTOMPOSTCOUNT => [
                ...$customPostFilterInputModules,
                ...$adminCustomPostFilterInputModules,
                ...$unionCustomPostFilterInputModules,
            ],
            self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOSTLISTCOUNT => $customPostFilterInputModules,
            self::MODULE_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTCOUNT => [
                ...$customPostFilterInputModules,
                ...$adminCustomPostFilterInputModules,
            ],
            default => [],
        };
    }

    /**
     * @return string[]
     */
    protected function getFilterInputHookNames(): array
    {
        return [
            ...parent::getFilterInputHookNames(),
            self::HOOK_FILTER_INPUTS,
        ];
    }
}
