<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use Exception;
use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\State\ApplicationState;
use PoP\EditUsers\HelperAPIFactory;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\CreateUpdateUserMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class CreateUpdateUserMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    protected ?CreateUpdateUserMutationResolver $createUpdateUserMutationResolver = null;
    
    public function setCreateUpdateUserMutationResolver(CreateUpdateUserMutationResolver $createUpdateUserMutationResolver): void
    {
        $this->createUpdateUserMutationResolver = $createUpdateUserMutationResolver;
    }
    protected function getCreateUpdateUserMutationResolver(): CreateUpdateUserMutationResolver
    {
        return $this->createUpdateUserMutationResolver ??= $this->instanceManager->getInstance(CreateUpdateUserMutationResolver::class);
    }

    //#[Required]
    final public function autowireCreateUpdateUserMutationResolverBridge(
        CreateUpdateUserMutationResolver $createUpdateUserMutationResolver,
    ): void {
        $this->createUpdateUserMutationResolver = $createUpdateUserMutationResolver;
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getCreateUpdateUserMutationResolver();
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        // For the update, gotta return the success string
        // If user is logged in => It's Update
        // Otherwise => It's Create
        $vars = ApplicationState::getVars();
        if ($vars['global-userstate']['is-user-logged-in']) {
            // Allow PoP Service Workers to add the attr to avoid the link being served from the browser cache
            return sprintf(
                $this->getTranslationAPI()->__('View your <a href="%s" target="%s" %s>updated profile</a>.', 'pop-application'),
                getAuthorProfileUrl($vars['global-userstate']['current-user-id']),
                \PoP_Application_Utils::getPreviewTarget(),
                $this->getHooksAPI()->applyFilters('GD_DataLoad_ActionExecuter_CreateUpdate_UserBase:success_msg:linkattrs', '')
            );
        }
    }

    public function getFormData(): array
    {
        $cmseditusershelpers = HelperAPIFactory::getInstance();
        $cmsapplicationhelpers = \PoP\Application\HelperAPIFactory::getInstance();
        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['is-user-logged-in'] ? $vars['global-userstate']['current-user-id'] : '';
        $inputs = $this->getFormInputs();
        $form_data = array(
            'user_id' => $user_id,
            'username' => $cmseditusershelpers->sanitizeUsername($this->getModuleProcessorManager()->getProcessor($inputs['username'])->getValue($inputs['username'])),
            'password' => $this->getModuleProcessorManager()->getProcessor($inputs['password'])->getValue($inputs['password']),
            'repeat_password' => $this->getModuleProcessorManager()->getProcessor($inputs['repeat_password'])->getValue($inputs['repeat_password']),
            'first_name' => trim($cmsapplicationhelpers->escapeAttributes($this->getModuleProcessorManager()->getProcessor($inputs['first_name'])->getValue($inputs['first_name']))),
            'user_email' => trim($this->getModuleProcessorManager()->getProcessor($inputs['user_email'])->getValue($inputs['user_email'])),
            'description' => trim($this->getModuleProcessorManager()->getProcessor($inputs['description'])->getValue($inputs['description'])),
            'user_url' => trim($this->getModuleProcessorManager()->getProcessor($inputs['user_url'])->getValue($inputs['user_url'])),
        );

        if (\PoP_Forms_ConfigurationUtils::captchaEnabled()) {
            $form_data['captcha'] = $this->getModuleProcessorManager()->getProcessor($inputs['captcha'])->getValue($inputs['captcha']);
        }

        // Allow to add extra inputs
        $form_data = $this->getHooksAPI()->applyFilters('gd_createupdate_user:form_data', $form_data);

        if ($user_id) {
            $form_data = $this->getUpdateuserFormData($form_data);
        } else {
            $form_data = $this->getCreateuserFormData($form_data);
        }

        return $form_data;
    }

    protected function getCreateuserFormData(array $form_data)
    {
        // Allow to add extra inputs
        $form_data = $this->getHooksAPI()->applyFilters('gd_createupdate_user:form_data:create', $form_data);

        return $form_data;
    }

    protected function getUpdateuserFormData(array $form_data)
    {
        // Allow to add extra inputs
        $form_data = $this->getHooksAPI()->applyFilters('gd_createupdate_user:form_data:update', $form_data);

        return $form_data;
    }

    private function getFormInputs()
    {
        $form_inputs = array(
            'username' => null,
            'password' => null,
            'repeat_password' => null,
            'first_name' => null,
            'user_email' => null,
            'description' => null,
            'user_url' => null,
        );

        if (\PoP_Forms_ConfigurationUtils::captchaEnabled()) {
            $form_inputs['captcha'] = null;
        }

        $inputs = $this->getHooksAPI()->applyFilters(
            'GD_CreateUpdate_User:form-inputs',
            $form_inputs
        );

        // If any input is null, throw an exception
        $null_inputs = array_filter($inputs, 'is_null');
        if ($null_inputs) {
            throw new Exception(
                sprintf(
                    'No form inputs defined for: %s',
                    '"' . implode('", "', array_keys($null_inputs)) . '"'
                )
            );
        }

        return $inputs;
    }
}
