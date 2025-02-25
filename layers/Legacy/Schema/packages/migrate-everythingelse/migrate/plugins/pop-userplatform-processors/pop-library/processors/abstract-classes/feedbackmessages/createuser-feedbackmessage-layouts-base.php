<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

abstract class PoP_Module_Processor_CreateUserFormMesageFeedbackLayoutsBase extends PoP_Module_Processor_FormFeedbackMessageLayoutsBase
{
    public function getMessages(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getMessages($component, $props);
            
        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        $ret['success-header'] = TranslationAPIFacade::getInstance()->__('Your user account was created successfully!', 'pop-coreprocessors');
        
        // Allow PoPTheme Wassup to add the emails to whitelist
        $ret['success'] = \PoP\Root\App::applyFilters(
            'PoP_Module_Processor_CreateUserFormMesageFeedbackLayoutsBase:success:msg',
            sprintf(
                '<p>%s</p>',
                sprintf(
                    TranslationAPIFacade::getInstance()->__('Please <a href="%s">click here to log-in</a>.', 'pop-coreprocessors'),
                    $cmsuseraccountapi->getLoginURL()
                )
            )
        );

        return $ret;
    }
}
