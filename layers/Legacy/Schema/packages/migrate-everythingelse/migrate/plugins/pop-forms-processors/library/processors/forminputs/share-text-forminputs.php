<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_Module_Processor_ShareTextFormInputs extends PoP_Module_Processor_TextFormInputsBase
{
    public final const MODULE_FORMINPUT_COPYSEARCHURL = 'copysearchurl';
    public final const MODULE_FORMINPUT_API = 'api';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMINPUT_COPYSEARCHURL],
            [self::class, self::MODULE_FORMINPUT_API],
        );
    }

    public function getLabelText(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_COPYSEARCHURL:
                return TranslationAPIFacade::getInstance()->__('Copy Search URL', 'pop-coreprocessors');

            case self::MODULE_FORMINPUT_API:
                return TranslationAPIFacade::getInstance()->__('Copy URL', 'pop-coreprocessors');
        }

        return parent::getLabelText($componentVariation, $props);
    }

    public function getPagesectionJsmethod(array $componentVariation, array &$props)
    {
        $ret = parent::getPagesectionJsmethod($componentVariation, $props);

        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_COPYSEARCHURL:
            case self::MODULE_FORMINPUT_API:
                // Because the method depends on modal.on('shown.bs.modal'), we need to run it before the modal is open for the first time
                // (when it would initialize the JS, so then this first execution would be lost otherwise)
                $this->addJsmethod($ret, 'replaceCode');
                break;
        }

        return $ret;
    }

    public function getImmutableJsconfiguration(array $componentVariation, array &$props): array
    {
        $ret = parent::getImmutableJsconfiguration($componentVariation, $props);

        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_API:
                // Needed for JS method `replaceCode`
                $ret['replaceCode']['url-type'] = 'api';
                break;
        }

        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_COPYSEARCHURL:
            case self::MODULE_FORMINPUT_API:
                $this->mergeProp(
                    $componentVariation,
                    $props,
                    'params',
                    array(
                        'data-code-placeholder' => '{0}'
                    )
                );
                break;
        }

        parent::initModelProps($componentVariation, $props);
    }
}



