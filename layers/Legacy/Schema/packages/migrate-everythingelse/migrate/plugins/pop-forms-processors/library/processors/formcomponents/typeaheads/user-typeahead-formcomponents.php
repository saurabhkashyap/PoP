<?php
use PoP\ComponentModel\ComponentProcessors\DataloadQueryArgsFilterInputComponentProcessorInterface;
use PoP\ComponentModel\ComponentProcessors\DataloadQueryArgsSchemaFilterInputComponentProcessorTrait;
use PoP\ComponentModel\FilterInputs\FilterInputInterface;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\IDScalarTypeResolver;
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use Symfony\Contracts\Service\Attribute\Required;

class PoP_Module_Processor_UserSelectableTypeaheadFilterInputs extends PoP_Module_Processor_UserSelectableTypeaheadFormComponentsBase implements DataloadQueryArgsFilterInputComponentProcessorInterface
{
    use DataloadQueryArgsSchemaFilterInputComponentProcessorTrait;

    public final const COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES = 'filtercomponent-selectabletypeahead-profiles';

    private ?IDScalarTypeResolver $idScalarTypeResolver = null;

    final public function setIDScalarTypeResolver(IDScalarTypeResolver $idScalarTypeResolver): void
    {
        $this->idScalarTypeResolver = $idScalarTypeResolver;
    }
    final protected function getIDScalarTypeResolver(): IDScalarTypeResolver
    {
        return $this->idScalarTypeResolver ??= $this->instanceManager->getInstance(IDScalarTypeResolver::class);
    }

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES,
        );
    }

    /**
     * @todo Migrate from [FilterInput::class, FilterInput::NAME] to FilterInputInterface
     */
    public function getFilterInput(\PoP\ComponentModel\Component\Component $component): ?FilterInputInterface
    {
        return match($component->name) {
            self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES => [PoP_Module_Processor_FormsFilterInput::class, PoP_Module_Processor_FormsFilterInput::FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES],
            default => null,
        };
    }

    // public function isFiltercomponent(\PoP\ComponentModel\Component\Component $component)
    // {
    //     switch ($component->name) {
    //         case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES:
    //             return true;
    //     }

    //     return parent::isFiltercomponent($component);
    // }

    public function getLabelText(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES:
                return TranslationAPIFacade::getInstance()->__('Authors', 'pop-coreprocessors');
        }

        return parent::getLabelText($component, $props);
    }

    public function getInputSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES:
                return [PoP_Module_Processor_TypeaheadTextFormInputs::class, PoP_Module_Processor_TypeaheadTextFormInputs::COMPONENT_FORMINPUT_TEXT_TYPEAHEADPROFILES];
        }

        return parent::getInputSubcomponent($component);
    }

    public function getComponentSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES:
                // Allow PoP Common User Roles to change this
                return \PoP\Root\App::applyFilters(
                    'UserSelectableTypeaheadFormInputs:components:profiles',
                    array(
                        [PoP_Module_Processor_UserTypeaheadComponentFormInputs::class, PoP_Module_Processor_UserTypeaheadComponentFormInputs::COMPONENT_TYPEAHEAD_COMPONENT_USERS],
                    )
                );
        }

        return parent::getComponentSubcomponents($component);
    }

    public function getTriggerLayoutSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES:
                return [PoP_Module_Processor_UserSelectableTypeaheadTriggerFormComponents::class, PoP_Module_Processor_UserSelectableTypeaheadTriggerFormComponents::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_PROFILES];
        }

        return parent::getTriggerLayoutSubcomponent($component);
    }

    public function getName(\PoP\ComponentModel\Component\Component $component): string
    {
        switch ($component->name) {
            case self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES:
                // Calling it either 'authors' or 'users' for some reason doesn't work!
                return 'profiles';
        }

        return parent::getName($component);
    }

    public function getFilterInputTypeResolver(\PoP\ComponentModel\Component\Component $component): InputTypeResolverInterface
    {
        return match($component->name) {
            self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES => $this->idScalarTypeResolver,
            default => $this->getDefaultSchemaFilterInputTypeResolver(),
        };
    }

    public function getFilterInputTypeModifiers(\PoP\ComponentModel\Component\Component $component): int
    {
        return match($component->name) {
            self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES => SchemaTypeModifiers::IS_ARRAY,
            default => SchemaTypeModifiers::NONE,
        };
    }

    public function getFilterInputDescription(\PoP\ComponentModel\Component\Component $component): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return match ($component->name) {
            self::COMPONENT_FILTERCOMPONENT_SELECTABLETYPEAHEAD_PROFILES => $translationAPI->__('', ''),
            default => null,
        };
    }
}



