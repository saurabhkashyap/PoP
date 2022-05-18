<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_Module_Processor_ShareTextareaFormInputs extends PoP_Module_Processor_TextareaFormInputsBase
{
    public final const MODULE_FORMINPUT_EMBEDCODE = 'embedcode';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMINPUT_EMBEDCODE],
        );
    }

    public function getLabelText(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_EMBEDCODE:
                return TranslationAPIFacade::getInstance()->__('Embed code', 'pop-coreprocessors');
        }

        return parent::getLabelText($componentVariation, $props);
    }

    public function getPagesectionJsmethod(array $componentVariation, array &$props)
    {
        $ret = parent::getPagesectionJsmethod($componentVariation, $props);

        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_EMBEDCODE:
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
            case self::MODULE_FORMINPUT_EMBEDCODE:
                // Needed for JS method `replaceCode`
                $ret['replaceCode']['url-type'] = 'embed';
                break;
        }

        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_EMBEDCODE:
                $placeholder = '<iframe width="100%" height="500" src="{0}" frameborder="0" allowfullscreen="true"></iframe>';
                $this->mergeProp(
                    $componentVariation,
                    $props,
                    'params',
                    array(
                        'data-code-placeholder' => $placeholder
                    )
                );
                break;
        }

        parent::initModelProps($componentVariation, $props);
    }
}



