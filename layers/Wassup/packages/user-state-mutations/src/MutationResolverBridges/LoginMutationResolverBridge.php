<?php

declare(strict_types=1);

namespace PoPSitesWassup\UserStateMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSchema\UserStateMutations\MutationResolvers\MutationInputProperties;
use PoPSitesWassup\UserStateMutations\MutationResolvers\LoginMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class LoginMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    protected ?LoginMutationResolver $loginMutationResolver = null;

    public function setLoginMutationResolver(LoginMutationResolver $loginMutationResolver): void
    {
        $this->loginMutationResolver = $loginMutationResolver;
    }
    protected function getLoginMutationResolver(): LoginMutationResolver
    {
        return $this->loginMutationResolver ??= $this->instanceManager->getInstance(LoginMutationResolver::class);
    }

    //#[Required]
    final public function autowireLoginMutationResolverBridge(
        LoginMutationResolver $loginMutationResolver,
    ): void {
        $this->loginMutationResolver = $loginMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getLoginMutationResolver();
    }

    public function getFormData(): array
    {
        return [
            MutationInputProperties::USERNAME_OR_EMAIL => trim($this->getModuleProcessorManager()->getProcessor([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_USERNAME])->getValue([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_USERNAME])),
            MutationInputProperties::PASSWORD => $this->getModuleProcessorManager()->getProcessor([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_PWD])->getValue([PoP_Module_Processor_LoginTextFormInputs::class, PoP_Module_Processor_LoginTextFormInputs::MODULE_FORMINPUT_LOGIN_PWD]),
        ];
    }
}
