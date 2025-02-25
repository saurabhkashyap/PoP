<?php

declare(strict_types=1);

namespace PoPCMSSchema\CustomPosts\ComponentProcessors\FormInputs;

use PoP\ComponentModel\Component\Component;
use PoP\ComponentModel\ComponentProcessors\AbstractFilterInputComponentProcessor;
use PoP\ComponentModel\ComponentProcessors\DataloadQueryArgsFilterInputComponentProcessorInterface;
use PoP\ComponentModel\FilterInputs\FilterInputInterface;
use PoP\ComponentModel\FormInputs\FormMultipleInput;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoPCMSSchema\CustomPosts\Enums\CustomPostStatus;
use PoPCMSSchema\CustomPosts\FilterInputs\CustomPostStatusFilterInput;
use PoPCMSSchema\CustomPosts\FilterInputs\UnionCustomPostTypesFilterInput;
use PoPCMSSchema\CustomPosts\TypeResolvers\EnumType\CustomPostEnumTypeResolver;
use PoPCMSSchema\CustomPosts\TypeResolvers\EnumType\FilterCustomPostStatusEnumTypeResolver;

class FilterInputComponentProcessor extends AbstractFilterInputComponentProcessor implements DataloadQueryArgsFilterInputComponentProcessorInterface
{
    public final const COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS = 'filterinput-custompoststatus';
    public final const COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES = 'filterinput-unioncustomposttypes';

    private ?FilterCustomPostStatusEnumTypeResolver $filterCustomPostStatusEnumTypeResolver = null;
    private ?CustomPostEnumTypeResolver $customPostEnumTypeResolver = null;
    private ?CustomPostStatusFilterInput $customPostStatusFilterInput = null;
    private ?UnionCustomPostTypesFilterInput $unionCustomPostTypesFilterInput = null;

    final public function setFilterCustomPostStatusEnumTypeResolver(FilterCustomPostStatusEnumTypeResolver $filterCustomPostStatusEnumTypeResolver): void
    {
        $this->filterCustomPostStatusEnumTypeResolver = $filterCustomPostStatusEnumTypeResolver;
    }
    final protected function getFilterCustomPostStatusEnumTypeResolver(): FilterCustomPostStatusEnumTypeResolver
    {
        return $this->filterCustomPostStatusEnumTypeResolver ??= $this->instanceManager->getInstance(FilterCustomPostStatusEnumTypeResolver::class);
    }
    final public function setCustomPostEnumTypeResolver(CustomPostEnumTypeResolver $customPostEnumTypeResolver): void
    {
        $this->customPostEnumTypeResolver = $customPostEnumTypeResolver;
    }
    final protected function getCustomPostEnumTypeResolver(): CustomPostEnumTypeResolver
    {
        return $this->customPostEnumTypeResolver ??= $this->instanceManager->getInstance(CustomPostEnumTypeResolver::class);
    }
    final public function setCustomPostStatusFilterInput(CustomPostStatusFilterInput $customPostStatusFilterInput): void
    {
        $this->customPostStatusFilterInput = $customPostStatusFilterInput;
    }
    final protected function getCustomPostStatusFilterInput(): CustomPostStatusFilterInput
    {
        return $this->customPostStatusFilterInput ??= $this->instanceManager->getInstance(CustomPostStatusFilterInput::class);
    }
    final public function setUnionCustomPostTypesFilterInput(UnionCustomPostTypesFilterInput $unionCustomPostTypesFilterInput): void
    {
        $this->unionCustomPostTypesFilterInput = $unionCustomPostTypesFilterInput;
    }
    final protected function getUnionCustomPostTypesFilterInput(): UnionCustomPostTypesFilterInput
    {
        return $this->unionCustomPostTypesFilterInput ??= $this->instanceManager->getInstance(UnionCustomPostTypesFilterInput::class);
    }

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS,
            self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES,
        );
    }

    public function getFilterInput(Component $component): ?FilterInputInterface
    {
        return match ($component->name) {
            self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS => $this->getCustomPostStatusFilterInput(),
            self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES => $this->getUnionCustomPostTypesFilterInput(),
            default => null,
        };
    }

    public function getInputClass(Component $component): string
    {
        switch ($component->name) {
            case self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS:
            case self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES:
                return FormMultipleInput::class;
        }

        return parent::getInputClass($component);
    }
    public function getName(Component $component): string
    {
        switch ($component->name) {
            case self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS:
            case self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES:
                // Add a nice name, so that the URL params when filtering make sense
                $names = array(
                    self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS => 'status',
                    self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES => 'customPostTypes',
                );
                return $names[$component->name];
        }

        return parent::getName($component);
    }

    public function getFilterInputTypeResolver(Component $component): InputTypeResolverInterface
    {
        return match ($component->name) {
            self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS => $this->getFilterCustomPostStatusEnumTypeResolver(),
            self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES => $this->getCustomPostEnumTypeResolver(),
            default => $this->getDefaultSchemaFilterInputTypeResolver(),
        };
    }

    public function getFilterInputTypeModifiers(Component $component): int
    {
        return match ($component->name) {
            self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS,
            self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES
                => SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default
                => SchemaTypeModifiers::NONE,
        };
    }

    public function getFilterInputDefaultValue(Component $component): mixed
    {
        return match ($component->name) {
            self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS => [
                CustomPostStatus::PUBLISH,
            ],
            self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES => $this->getCustomPostEnumTypeResolver()->getConsolidatedEnumValues(),
            default => null,
        };
    }

    public function getFilterInputDescription(Component $component): ?string
    {
        return match ($component->name) {
            self::COMPONENT_FILTERINPUT_CUSTOMPOSTSTATUS => $this->__('Custom Post Status', 'customposts'),
            self::COMPONENT_FILTERINPUT_UNIONCUSTOMPOSTTYPES => $this->__('Return results from Union of the Custom Post Types', 'customposts'),
            default => null,
        };
    }
}
