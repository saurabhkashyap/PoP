<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoPTheme_Wassup_CommonPages_ContentCreation_PageSectionHooks
{
    public function __construct()
    {
        // \PoP\Root\App::addFilter(
        //     'PoP_Module_Processor_CustomModalPageSections:getHeaderTitles:modals',
        //     $this->modalHeaderTitles(...)
        // );
    }

    // public function modalHeaderTitles($headerTitles)
    // {
    //     $faqs = sprintf(
    //         '<i class="fa fa-fw fa-info-circle"></i>%s',
    //         TranslationAPIFacade::getInstance()->__('FAQs', 'poptheme-wassup')
    //     );

    //     $headerTitles[GD_CommonPages_Module_Processor_CustomBlocks::COMPONENT_BLOCK_ADDCONTENTFAQ] = $faqs;

    //     return $headerTitles;
    // }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_CommonPages_ContentCreation_PageSectionHooks();
