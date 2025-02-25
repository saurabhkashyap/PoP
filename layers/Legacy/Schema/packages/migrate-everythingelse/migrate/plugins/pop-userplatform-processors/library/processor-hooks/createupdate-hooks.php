<?php

class PoP_UserPlatform_CreateUpdateHooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'GD_CreateUpdate_Profile:form-inputs',
            $this->getProfileFormInputs(...)
        );
        \PoP\Root\App::addFilter(
            'GD_CreateUpdate_User:form-inputs',
            $this->getUserFormInputs(...)
        );
    }

    public function getProfileFormInputs($inputs = array())
    {
        return array_merge(
            $inputs,
            array(
                'short_description' => [PoP_Module_Processor_CreateUpdateProfileTextFormInputs::class, PoP_Module_Processor_CreateUpdateProfileTextFormInputs::COMPONENT_FORMINPUT_CUP_SHORTDESCRIPTION],
                'display_email' => [PoP_Module_Processor_CreateUpdateProfileCheckboxFormInputs::class, PoP_Module_Processor_CreateUpdateProfileCheckboxFormInputs::COMPONENT_FORMINPUT_CUP_DISPLAYEMAIL],
                'facebook' => [PoP_Module_Processor_CreateUpdateProfileTextFormInputs::class, PoP_Module_Processor_CreateUpdateProfileTextFormInputs::COMPONENT_FORMINPUT_CUP_FACEBOOK],
                'twitter' => [PoP_Module_Processor_CreateUpdateProfileTextFormInputs::class, PoP_Module_Processor_CreateUpdateProfileTextFormInputs::COMPONENT_FORMINPUT_CUP_TWITTER],
                'linkedin' => [PoP_Module_Processor_CreateUpdateProfileTextFormInputs::class, PoP_Module_Processor_CreateUpdateProfileTextFormInputs::COMPONENT_FORMINPUT_CUP_LINKEDIN],
                'youtube' => [PoP_Module_Processor_CreateUpdateProfileTextFormInputs::class, PoP_Module_Processor_CreateUpdateProfileTextFormInputs::COMPONENT_FORMINPUT_CUP_YOUTUBE],
                'instagram' => [PoP_Module_Processor_CreateUpdateProfileTextFormInputs::class, PoP_Module_Processor_CreateUpdateProfileTextFormInputs::COMPONENT_FORMINPUT_CUP_INSTAGRAM],
                // 'blog' => self::COMPONENT_FORMINPUT_CUP_BLOG,
            )
        );
    }

    public function getUserFormInputs($inputs = array())
    {
        return array_merge(
            $inputs,
            array(
                'username' => [PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_USERNAME],
                'password' => [PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_PASSWORD],
                'repeat_password' => [PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_PASSWORDREPEAT],
                'first_name' => [PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_FIRSTNAME],
                'user_email' => [PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_EMAIL],
                'description' => [PoP_Module_Processor_CreateUpdateUserTextareaFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextareaFormInputs::COMPONENT_FORMINPUT_CUU_DESCRIPTION],
                'user_url' => [PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_USERWEBSITEURL],
            ),
            (
            PoP_Forms_ConfigurationUtils::captchaEnabled() ?
                    array(
                        'captcha' => [PoP_Module_Processor_CaptchaFormInputs::class, PoP_Module_Processor_CaptchaFormInputs::COMPONENT_FORMINPUT_CAPTCHA],
                    ) : array()
            )
        );
    }
}


/**
 * Initialization
 */
new PoP_UserPlatform_CreateUpdateHooks();
