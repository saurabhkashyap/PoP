<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_Module_Processor_ShareContents extends PoP_Module_Processor_ContentsBase
{
    public final const MODULE_CONTENT_EMBEDPREVIEW = 'content-embedpreview';
    public final const MODULE_CONTENT_EMBED = 'content-embed';
    public final const MODULE_CONTENT_API = 'content-api';
    public final const MODULE_CONTENT_COPYSEARCHURL = 'content-copysearchurl';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CONTENT_EMBEDPREVIEW],
            [self::class, self::MODULE_CONTENT_EMBED],
            [self::class, self::MODULE_CONTENT_API],
            [self::class, self::MODULE_CONTENT_COPYSEARCHURL],
        );
    }

    protected function getDescription(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_CONTENT_EMBEDPREVIEW:
                return sprintf(
                    '<h4><i class="fa fa-fw fa-eye"></i>%s</h4>',
                    TranslationAPIFacade::getInstance()->__('Preview:', 'pop-coreprocessors')
                );

            case self::MODULE_CONTENT_EMBED:
                return sprintf(
                    '<p><em>%s</em></p>',
                    TranslationAPIFacade::getInstance()->__('Please copy/paste the html code below into your website.', 'pop-coreprocessors')
                );

            case self::MODULE_CONTENT_COPYSEARCHURL:
            case self::MODULE_CONTENT_API:
                return sprintf(
                    '<p><em>%s</em></p>',
                    TranslationAPIFacade::getInstance()->__('Please select and copy (Ctrl + C) the URL below.', 'pop-coreprocessors')
                );
        }

        return parent::getDescription($componentVariation, $props);
    }

    public function getInnerSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_CONTENT_EMBEDPREVIEW:
                return [PoP_Module_Processor_ShareContentInners::class, PoP_Module_Processor_ShareContentInners::MODULE_CONTENTINNER_EMBEDPREVIEW];

            case self::MODULE_CONTENT_EMBED:
                return [PoP_Module_Processor_ShareContentInners::class, PoP_Module_Processor_ShareContentInners::MODULE_CONTENTINNER_EMBED];

            case self::MODULE_CONTENT_API:
                return [PoP_Module_Processor_ShareContentInners::class, PoP_Module_Processor_ShareContentInners::MODULE_CONTENTINNER_API];

            case self::MODULE_CONTENT_COPYSEARCHURL:
                return [PoP_Module_Processor_ShareContentInners::class, PoP_Module_Processor_ShareContentInners::MODULE_CONTENTINNER_COPYSEARCHURL];
        }

        return parent::getInnerSubmodule($componentVariation);
    }
}


