<?php

declare(strict_types=1);

namespace PoPCMSSchema\Categories\ConditionalOnModule\API\ComponentProcessors;

use PoP\ComponentModel\Component\Component;
use PoPAPI\API\ComponentProcessors\AbstractRelationalFieldDataloadComponentProcessor;
use PoP\ComponentModel\QueryInputOutputHandlers\ListQueryInputOutputHandler;
use PoP\ComponentModel\QueryInputOutputHandlers\QueryInputOutputHandlerInterface;
use PoPCMSSchema\Categories\ComponentProcessors\CategoryFilterInputContainerComponentProcessor;
use PoPCMSSchema\QueriedObject\ComponentProcessors\QueriedDBObjectComponentProcessorTrait;

abstract class AbstractFieldDataloadComponentProcessor extends AbstractRelationalFieldDataloadComponentProcessor
{
    use QueriedDBObjectComponentProcessorTrait;

    public final const COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORY = 'dataload-relationalfields-category';
    public final const COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORYLIST = 'dataload-relationalfields-categorylist';
    public final const COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORYCOUNT = 'dataload-relationalfields-categorycount';

    private ?ListQueryInputOutputHandler $listQueryInputOutputHandler = null;

    final public function setListQueryInputOutputHandler(ListQueryInputOutputHandler $listQueryInputOutputHandler): void
    {
        $this->listQueryInputOutputHandler = $listQueryInputOutputHandler;
    }
    final protected function getListQueryInputOutputHandler(): ListQueryInputOutputHandler
    {
        return $this->listQueryInputOutputHandler ??= $this->instanceManager->getInstance(ListQueryInputOutputHandler::class);
    }

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORY,
            self::COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORYLIST,
            self::COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORYCOUNT,
        );
    }

    public function getObjectIDOrIDs(Component $component, array &$props, &$data_properties): string | int | array | null
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORY:
                return $this->getQueriedDBObjectID($component, $props, $data_properties);
        }

        return parent::getObjectIDOrIDs($component, $props, $data_properties);
    }

    public function getQueryInputOutputHandler(Component $component): ?QueryInputOutputHandlerInterface
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORYLIST:
                return $this->getListQueryInputOutputHandler();
        }

        return parent::getQueryInputOutputHandler($component);
    }

    public function getFilterSubcomponent(Component $component): ?Component
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORYLIST:
                return new Component(CategoryFilterInputContainerComponentProcessor::class, CategoryFilterInputContainerComponentProcessor::COMPONENT_FILTERINPUTCONTAINER_CATEGORIES);
            case self::COMPONENT_DATALOAD_RELATIONALFIELDS_CATEGORYCOUNT:
                return new Component(CategoryFilterInputContainerComponentProcessor::class, CategoryFilterInputContainerComponentProcessor::COMPONENT_FILTERINPUTCONTAINER_CATEGORYCOUNT);
        }

        return parent::getFilterSubcomponent($component);
    }
}
