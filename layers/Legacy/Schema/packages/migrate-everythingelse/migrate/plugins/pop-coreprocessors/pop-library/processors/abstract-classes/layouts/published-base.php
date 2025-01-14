<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\CustomPosts\Types\Status;

abstract class PoP_Module_Processor_PostStatusDateLayoutsBase extends PoPEngine_QueryDataComponentProcessorBase
{
    public function getTemplateResource(\PoP\ComponentModel\Component\Component $component, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_LAYOUT_POSTSTATUSDATE];
    }

    /**
     * @todo Migrate from string to LeafComponentFieldNode
     *
     * @return \PoP\ComponentModel\GraphQLEngine\Model\ComponentModelSpec\LeafComponentFieldNode[]
     */
    public function getLeafComponentFieldNodes(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        return array('date', 'status');
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        $ret[GD_JS_TITLES] = array(
            Status::PUBLISHED => TranslationAPIFacade::getInstance()->__('Published', 'pop-coreprocessors'),
            Status::PENDING => TranslationAPIFacade::getInstance()->__('Pending', 'pop-coreprocessors'),
            Status::DRAFT => TranslationAPIFacade::getInstance()->__('Draft', 'pop-coreprocessors'),
        );

        return $ret;
    }
}
