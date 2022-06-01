<?php

declare(strict_types=1);

namespace PoPCMSSchema\Pages\ComponentProcessors;

use PoP\ComponentModel\Component\Component;
use PoPCMSSchema\CustomPosts\ComponentProcessors\CustomPostFilterInputContainerComponentProcessor;
use PoPCMSSchema\SchemaCommons\ComponentProcessors\FormInputs\CommonFilterInputComponentProcessor;

class PageFilterInputContainerComponentProcessor extends CustomPostFilterInputContainerComponentProcessor
{
    public const HOOK_FILTER_INPUTS = __CLASS__ . ':filter-inputs';

    public final const COMPONENT_FILTERINPUTCONTAINER_PAGELISTLIST = 'filterinputcontainer-pagelist';
    public final const COMPONENT_FILTERINPUTCONTAINER_PAGELISTCOUNT = 'filterinputcontainer-pagecount';
    public final const COMPONENT_FILTERINPUTCONTAINER_ADMINPAGELISTLIST = 'filterinputcontainer-adminpagelist';
    public final const COMPONENT_FILTERINPUTCONTAINER_ADMINPAGELISTCOUNT = 'filterinputcontainer-adminpagecount';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_FILTERINPUTCONTAINER_PAGELISTLIST],
            [self::class, self::COMPONENT_FILTERINPUTCONTAINER_PAGELISTCOUNT],
            [self::class, self::COMPONENT_FILTERINPUTCONTAINER_ADMINPAGELISTLIST],
            [self::class, self::COMPONENT_FILTERINPUTCONTAINER_ADMINPAGELISTCOUNT],
        );
    }

    public function getFilterInputComponents(\PoP\ComponentModel\Component\Component $component): array
    {
        // Get the original config from above
        $targetModule = match ($component[1]) {
            self::COMPONENT_FILTERINPUTCONTAINER_PAGELISTLIST => new Component(parent::class, parent::COMPONENT_FILTERINPUTCONTAINER_CUSTOMPOSTLISTLIST),
            self::COMPONENT_FILTERINPUTCONTAINER_PAGELISTCOUNT => new Component(parent::class, parent::COMPONENT_FILTERINPUTCONTAINER_CUSTOMPOSTLISTCOUNT),
            self::COMPONENT_FILTERINPUTCONTAINER_ADMINPAGELISTLIST => new Component(parent::class, parent::COMPONENT_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTLIST),
            self::COMPONENT_FILTERINPUTCONTAINER_ADMINPAGELISTCOUNT => new Component(parent::class, parent::COMPONENT_FILTERINPUTCONTAINER_ADMINCUSTOMPOSTLISTCOUNT),
            default => null,
        };
        $filterInputComponents = parent::getFilterInputComponents($targetModule);
        // Add the parentIDs and parentID filterInputs
        $filterInputComponents[] = new \PoP\ComponentModel\Component\Component(CommonFilterInputComponentProcessor::class, CommonFilterInputComponentProcessor::COMPONENT_FILTERINPUT_PARENT_IDS);
        $filterInputComponents[] = new \PoP\ComponentModel\Component\Component(CommonFilterInputComponentProcessor::class, CommonFilterInputComponentProcessor::COMPONENT_FILTERINPUT_PARENT_ID);
        $filterInputComponents[] = new \PoP\ComponentModel\Component\Component(CommonFilterInputComponentProcessor::class, CommonFilterInputComponentProcessor::COMPONENT_FILTERINPUT_EXCLUDE_PARENT_IDS);
        return $filterInputComponents;
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
