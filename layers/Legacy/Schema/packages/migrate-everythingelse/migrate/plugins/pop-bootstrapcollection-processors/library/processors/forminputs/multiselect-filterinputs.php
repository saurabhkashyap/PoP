<?php
use PoP\ComponentModel\ModuleProcessors\DataloadQueryArgsFilterInputModuleProcessorInterface;
use PoP\ComponentModel\ModuleProcessors\DataloadQueryArgsSchemaFilterInputModuleProcessorTrait;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoPSchema\EverythingElse\TypeResolvers\EnumType\CustomPostModeratedStatusEnumTypeResolver;
use PoPSchema\EverythingElse\TypeResolvers\EnumType\CustomPostUnmoderatedStatusEnumTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class PoP_Module_Processor_MultiSelectFilterInputs extends PoP_Module_Processor_MultiSelectFormInputsBase implements DataloadQueryArgsFilterInputModuleProcessorInterface
{
    use DataloadQueryArgsSchemaFilterInputModuleProcessorTrait;

    public const MODULE_FILTERINPUT_MODERATEDPOSTSTATUS = 'filterinput-moderatedpoststatus';
    public const MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS = 'filterinput-unmoderatedpoststatus';

    protected ?CustomPostModeratedStatusEnumTypeResolver $customPostModeratedStatusEnumTypeResolver = null;
    protected ?CustomPostUnmoderatedStatusEnumTypeResolver $customPostUnmoderatedStatusEnumTypeResolver = null;

    public function setCustomPostModeratedStatusEnumTypeResolver(CustomPostModeratedStatusEnumTypeResolver $customPostModeratedStatusEnumTypeResolver): void
    {
        $this->customPostModeratedStatusEnumTypeResolver = $customPostModeratedStatusEnumTypeResolver;
    }
    protected function getCustomPostModeratedStatusEnumTypeResolver(): CustomPostModeratedStatusEnumTypeResolver
    {
        return $this->customPostModeratedStatusEnumTypeResolver ??= $this->getInstanceManager()->getInstance(CustomPostModeratedStatusEnumTypeResolver::class);
    }
    public function setCustomPostUnmoderatedStatusEnumTypeResolver(CustomPostUnmoderatedStatusEnumTypeResolver $customPostUnmoderatedStatusEnumTypeResolver): void
    {
        $this->customPostUnmoderatedStatusEnumTypeResolver = $customPostUnmoderatedStatusEnumTypeResolver;
    }
    protected function getCustomPostUnmoderatedStatusEnumTypeResolver(): CustomPostUnmoderatedStatusEnumTypeResolver
    {
        return $this->customPostUnmoderatedStatusEnumTypeResolver ??= $this->getInstanceManager()->getInstance(CustomPostUnmoderatedStatusEnumTypeResolver::class);
    }

    //#[Required]
    final public function autowirePoP_Module_Processor_MultiSelectFilterInputs(
        CustomPostModeratedStatusEnumTypeResolver $customPostModeratedStatusEnumTypeResolver,
        CustomPostUnmoderatedStatusEnumTypeResolver $customPostUnmoderatedStatusEnumTypeResolver,
    ): void {
        $this->customPostModeratedStatusEnumTypeResolver = $customPostModeratedStatusEnumTypeResolver;
        $this->customPostUnmoderatedStatusEnumTypeResolver = $customPostUnmoderatedStatusEnumTypeResolver;
    }

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS],
            [self::class, self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS],
        );
    }

    public function getFilterInput(array $module): ?array
    {
        $filterInputs = [
            self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS => [PoP_Module_Processor_MultiSelectFilterInputProcessor::class, PoP_Module_Processor_MultiSelectFilterInputProcessor::FILTERINPUT_MODERATEDPOSTSTATUS],
            self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS => [PoP_Module_Processor_MultiSelectFilterInputProcessor::class, PoP_Module_Processor_MultiSelectFilterInputProcessor::FILTERINPUT_UNMODERATEDPOSTSTATUS],
        ];
        return $filterInputs[$module[1]] ?? null;
    }

    // public function isFiltercomponent(array $module)
    // {
    //     switch ($module[1]) {
    //         case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
    //         case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
    //             return true;
    //     }

    //     return parent::isFiltercomponent($module);
    // }

    public function getLabelText(array $module, array &$props)
    {
        switch ($module[1]) {
            case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
            case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
                return TranslationAPIFacade::getInstance()->__('Status', 'pop-coreprocessors');
        }

        return parent::getLabelText($module, $props);
    }

    public function getInputClass(array $module): string
    {
        switch ($module[1]) {
            case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
                return GD_FormInput_ModeratedStatus::class;

            case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
                return GD_FormInput_UnmoderatedStatus::class;
        }

        return parent::getInputClass($module);
    }

    public function getName(array $module): string
    {
        switch ($module[1]) {
            case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
            case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
                // Add a nice name, so that the URL params when filtering make sense
                return 'status';
        }

        return parent::getName($module);
    }

    public function getFilterInputTypeResolver(array $module): InputTypeResolverInterface
    {
        return match($module[1]) {
            self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS => $this->customPostModeratedStatusEnumTypeResolver,
            self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS => $this->customPostUnmoderatedStatusEnumTypeResolver,
            default => $this->getDefaultSchemaFilterInputTypeResolver(),
        };
    }

    public function getFilterInputTypeModifiers(array $module): int
    {
        return match($module[1]) {
            self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS,
            self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS
                => SchemaTypeModifiers::IS_ARRAY,
            default
                => SchemaTypeModifiers::NONE,
        };
    }

    public function getFilterInputDescription(array $module): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return match ($module[1]) {
            self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS => $translationAPI->__('', ''),
            self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS => $translationAPI->__('', ''),
            default => null,
        };
    }
}



