<?php

declare(strict_types=1);

namespace PoPSitesWassup\UserStateMutations\MutationResolverBridges;

use PoP\Hooks\HooksAPIInterface;
use PoP\Translation\TranslationAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\MutationResolution\MutationResolutionManagerInterface;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\UserStateMutations\MutationResolvers\MutationInputProperties;
use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoPSitesWassup\UserStateMutations\MutationResolvers\ResetLostPasswordMutationResolver;

class ResetLostPasswordMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    protected ResetLostPasswordMutationResolver $resetLostPasswordMutationResolver;
    public function __construct(
        HooksAPIInterface $hooksAPI,
        TranslationAPIInterface $translationAPI,
        InstanceManagerInterface $instanceManager,
        MutationResolutionManagerInterface $mutationResolutionManager,
        ResetLostPasswordMutationResolver $resetLostPasswordMutationResolver,
    ) {
        $this->resetLostPasswordMutationResolver = $resetLostPasswordMutationResolver;
        parent::__construct(
            $hooksAPI,
            $translationAPI,
            $instanceManager,
            $mutationResolutionManager,
        );
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->resetLostPasswordMutationResolver;
    }

    public function getFormData(): array
    {
        return [
            MutationInputProperties::CODE => trim($this->moduleProcessorManager->getProcessor([\PoP_Module_Processor_LoginTextFormInputs::class, \PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_CODE])->getValue([\PoP_Module_Processor_LoginTextFormInputs::class, \PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_CODE])),
            MutationInputProperties::PASSWORD => trim($this->moduleProcessorManager->getProcessor([\PoP_Module_Processor_LoginTextFormInputs::class, \PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_NEWPASSWORD])->getValue([\PoP_Module_Processor_LoginTextFormInputs::class, \PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_NEWPASSWORD])),
            MutationInputProperties::REPEAT_PASSWORD => trim($this->moduleProcessorManager->getProcessor([\PoP_Module_Processor_LoginTextFormInputs::class, \PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_PASSWORDREPEAT])->getValue([\PoP_Module_Processor_LoginTextFormInputs::class, \PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOSTPWDRESET_PASSWORDREPEAT])),
        ];
    }
}
