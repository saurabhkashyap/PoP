<?php

use PoP\ComponentModel\Misc\RequestUtils;

abstract class PoP_Module_Processor_TabPanePageSectionsBase extends PoP_Module_Processor_BootstrapPageSectionsBase
{
    public function getTemplateResource(array $componentVariation, array &$props): ?array
    {
        return [PoP_BootstrapWebPlatform_TemplateResourceLoaderProcessor::class, PoP_BootstrapWebPlatform_TemplateResourceLoaderProcessor::RESOURCE_PAGESECTION_TABPANE];
    }

    public function getHeaderClass(array $componentVariation)
    {
        return '';
    }
    public function getHeaderTitles(array $componentVariation)
    {
        return array();
    }

    public function getImmutableConfiguration(array $componentVariation, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($componentVariation, $props);

        if ($header_class = $this->getHeaderClass($componentVariation)) {
            $ret[GD_JS_CLASSES]['header'] = $header_class;
        }
        if ($headerTitles = $this->getHeaderTitles($componentVariation)) {
            $ret[GD_JS_TITLES]['headers'] = $headerTitles;
        }

        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        $this->appendProp($componentVariation, $props, 'class', 'pop-pagesection-page pop-viewport toplevel');
        $this->mergeProp(
            $componentVariation,
            $props,
            'params',
            array(
                'data-paramsscope' => GD_SETTINGS_PARAMSSCOPE_URL
            )
        );

        // If PoP SSR is not defined, then there is no PoP_SSR_ServerUtils
        if (defined('POP_SSR_INITIALIZED')) {
            // If doing Server-side rendering, then already add "active" to the tabPane, to not depend on javascript
            // (Otherwise, the page will look empty!)
            if (RequestUtils::loadingSite() && !PoP_SSR_ServerUtils::disableServerSideRendering()) {
                $this->appendProp($componentVariation, $props, 'class', 'active');
            }
        }

        parent::initModelProps($componentVariation, $props);
    }

    protected function getInitjsBlockbranches(array $componentVariation, array &$props)
    {
        $ret = parent::getInitjsBlockbranches($componentVariation, $props);

        // 2 possibilities: with the merge container (eg: main) or without it (eg: quickview)
        $id = $this->getFrontendId($componentVariation, $props);

        // Comment Leo 10/12/2016: in the past, we did .tab-pane.active, however that doesn't work anymore for when alt+click to open a link
        // So instead, just pick the last added .tab-pane
        $ret[] = '#'.$id.'-merge > div.tab-pane:last-child > div.pop-block';
        $ret[] = '#'.$id.' > div.tab-pane:last-child > div.pop-block';

        return $ret;
    }
}
