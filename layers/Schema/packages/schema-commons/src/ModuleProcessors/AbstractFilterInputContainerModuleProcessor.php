<?php

declare(strict_types=1);

namespace PoPSchema\SchemaCommons\ModuleProcessors;

use PoP\ComponentModel\ModuleProcessors\AbstractQueryableDataModuleProcessor;
use PoP\ComponentModel\Facades\FilterInputProcessors\FilterInputProcessorManagerFacade;
use PoP\ComponentModel\ModuleProcessors\FormComponentModuleProcessorInterface;
use PoPSchema\SchemaCommons\ModuleProcessors\FormInputs\CommonFilterInputModuleProcessor;

abstract class AbstractFilterInputContainerModuleProcessor extends AbstractQueryableDataModuleProcessor
{
    public const HOOK_FILTER_INPUTS = __CLASS__ . ':filter-inputs';

    final public function getSubmodules(array $module): array
    {
        $filterInputModules = $this->getFilterInputModules($module);

        // Enable extensions to add more FilterInputs
        foreach ($this->getFilterInputHookNames() as $filterInputHookName) {
            $filterInputModules = $this->hooksAPI->applyFilters(
                $filterInputHookName,
                $filterInputModules,
                $module
            );
        }

        // Add the filterInputs to whatever came from the parent (if anything)
        return array_merge(
            parent::getSubmodules($module),
            $filterInputModules
        );
    }

    abstract public function getFilterInputModules(array $module): array;

    /**
     * @return string[]
     */
    protected function getFilterInputHookNames(): array
    {
        return [
            self::HOOK_FILTER_INPUTS,
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    protected function getPaginationFilterInputModules(): array
    {
        return [
            [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_ORDER],
            [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_LIMIT],
            [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_OFFSET],
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    protected function getIDFilterInputModules(): array
    {
        return [
            [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_IDS],
            [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_ID],
            [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_EXCLUDE_IDS],
        ];
    }
    protected function getFilterInputName(array $filterInput): string
    {
        $filterInputProcessorManager = FilterInputProcessorManagerFacade::getInstance();
        /** @var FormComponentModuleProcessorInterface */
        $filterInputProcessor = $filterInputProcessorManager->getProcessor($filterInput);
        return $filterInputProcessor->getName($filterInput);
    }
    
    /**
     * Provide default values for modules in the FilterInputContainer
     * @return array<string,mixed> A list of filterInputName as key, and its value
     */
    public function getFieldDataFilteringDefaultValues(array $module): array
    {
        return [];
    }

    /**
     * Provide the names of the args which are mandatory in the FilterInput
     * @return string[]
     */
    public function getFieldDataFilteringMandatoryArgs(array $module): array
    {
        return [];
    }
}
