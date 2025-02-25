<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\Users\Facades\UserTypeAPIFacade;

class PoP_Forms_Module_Processor_TextFormInputs extends PoP_Module_Processor_TextFormInputsBase
{
    public final const COMPONENT_FORMINPUT_NAME = 'gf-field-name';
    public final const COMPONENT_FORMINPUT_EMAIL = 'gf-field-email';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_FORMINPUT_NAME,
            self::COMPONENT_FORMINPUT_EMAIL,
        );
    }

    public function getLabelText(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_FORMINPUT_NAME:
                return TranslationAPIFacade::getInstance()->__('Your Name', 'pop-genericforms');

            case self::COMPONENT_FORMINPUT_EMAIL:
                return TranslationAPIFacade::getInstance()->__('Your Email', 'pop-genericforms');
        }

        return parent::getLabelText($component, $props);
    }

    public function isMandatory(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_FORMINPUT_NAME:
            case self::COMPONENT_FORMINPUT_EMAIL:
                return true;
        }

        return parent::isMandatory($component, $props);
    }

    public function getInputOptions(\PoP\ComponentModel\Component\Component $component): array
    {
        $options = parent::getInputOptions($component);

        // When submitting the form, if user is logged in, then use these values.
        // Otherwise, use the values sent in the form
        if (PoP_FormUtils::useLoggedinuserData() && doingPost() && \PoP\Root\App::getState('is-user-logged-in')) {
            $user_id = \PoP\Root\App::getState('current-user-id');
            $userTypeAPI = UserTypeAPIFacade::getInstance();
            switch ($component->name) {
                case self::COMPONENT_FORMINPUT_NAME:
                    $options['selected'] = $userTypeAPI->getUserDisplayName($user_id);
                    break;

                case self::COMPONENT_FORMINPUT_EMAIL:
                    $options['selected'] = $userTypeAPI->getUserEmail($user_id);
                    break;
            }
        }

        return $options;
    }

    public function getJsmethods(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getJsmethods($component, $props);

        switch ($component->name) {
            case self::COMPONENT_FORMINPUT_NAME:
            case self::COMPONENT_FORMINPUT_EMAIL:
                $this->addJsmethod($ret, 'addDomainClass');
                break;
        }

        return $ret;
    }
    public function getImmutableJsconfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableJsconfiguration($component, $props);

        switch ($component->name) {
            case self::COMPONENT_FORMINPUT_NAME:
            case self::COMPONENT_FORMINPUT_EMAIL:
                // For function addDomainClass
                $ret['addDomainClass']['prefix'] = 'visible-notloggedin-';
                break;
        }

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_FORMINPUT_NAME:
            case self::COMPONENT_FORMINPUT_EMAIL:
                $this->appendProp($component, $props, 'class', 'visible-notloggedin');

                // If we don't use the loggedinuser-data, then show the inputs always
                if (!PoP_FormUtils::useLoggedinuserData()) {
                    $this->appendProp($component, $props, 'class', 'visible-always');
                }
                break;
        }

        parent::initModelProps($component, $props);
    }
}



