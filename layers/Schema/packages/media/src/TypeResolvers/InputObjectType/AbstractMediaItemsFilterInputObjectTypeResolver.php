<?php

declare(strict_types=1);

namespace PoPSchema\Media\TypeResolvers\InputObjectType;

use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoPSchema\Media\FilterInputProcessors\FilterInputProcessor;
use PoPSchema\CustomPosts\TypeResolvers\InputObjectType\CustomPostDateQueryInputObjectTypeResolver;
use PoPSchema\SchemaCommons\FilterInputProcessors\FilterInputProcessor as SchemaCommonsFilterInputProcessor;
use PoPSchema\SchemaCommons\TypeResolvers\InputObjectType\AbstractObjectsFilterInputObjectTypeResolver;

abstract class AbstractMediaItemsFilterInputObjectTypeResolver extends AbstractObjectsFilterInputObjectTypeResolver
{
    private ?CustomPostDateQueryInputObjectTypeResolver $customPostDateQueryInputObjectTypeResolver = null;

    final public function setCustomPostDateQueryInputObjectTypeResolver(CustomPostDateQueryInputObjectTypeResolver $customPostDateQueryInputObjectTypeResolver): void
    {
        $this->customPostDateQueryInputObjectTypeResolver = $customPostDateQueryInputObjectTypeResolver;
    }
    final protected function getCustomPostDateQueryInputObjectTypeResolver(): CustomPostDateQueryInputObjectTypeResolver
    {
        return $this->customPostDateQueryInputObjectTypeResolver ??= $this->instanceManager->getInstance(CustomPostDateQueryInputObjectTypeResolver::class);
    }

    public function getInputFieldNameTypeResolvers(): array
    {
        return array_merge(
            parent::getInputFieldNameTypeResolvers(),
            [
                'search' => $this->getStringScalarTypeResolver(),
                'dateQuery' => $this->getCustomPostDateQueryInputObjectTypeResolver(),
                'mimeTypes' => $this->getStringScalarTypeResolver(),
            ]
        );
    }

    public function getInputFieldDescription(string $inputFieldName): ?string
    {
        return match ($inputFieldName) {
            'search' => $this->getTranslationAPI()->__('Search for comments containing the given string', 'comments'),
            'dateQuery' => $this->getTranslationAPI()->__('Filter comments based on date', 'comments'),
            'mimeTypes' => $this->getTranslationAPI()->__('Filter comments based on type', 'comments'),
            default => parent::getInputFieldDescription($inputFieldName),
        };
    }

    public function getInputFieldDefaultValue(string $inputFieldName): mixed
    {
        return match ($inputFieldName) {
            'mimeTypes' => [
                'image',
            ],
            default => parent::getInputFieldDefaultValue($inputFieldName)
        };
    }

    public function getInputFieldTypeModifiers(string $inputFieldName): int
    {
        return match ($inputFieldName) {
            'mimeTypes' => SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default => parent::getInputFieldTypeModifiers($inputFieldName)
        };
    }

    public function getInputFieldFilterInput(string $inputFieldName): ?array
    {
        return match ($inputFieldName) {
            'search' => [SchemaCommonsFilterInputProcessor::class, SchemaCommonsFilterInputProcessor::FILTERINPUT_SEARCH],
            'mimeTypes' => [FilterInputProcessor::class, FilterInputProcessor::FILTERINPUT_MIME_TYPES],
            default => parent::getInputFieldFilterInput($inputFieldName),
        };
    }
}