<?php

define('POP_HOOK_SCROLLINNER_THUMBNAIL_GRID', 'scrollinner-thumbnail-grid');

abstract class PoP_Module_Processor_ScrollInnersBase extends PoP_Module_Processor_StructureInnersBase
{
    public function getTemplateResource(array $componentVariation, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_SCROLL_INNER];
    }

    public function getLayoutGrid(array $componentVariation, array &$props)
    {
        return array(
            'row-items' => 1,
            'class' => 'col-sm-12'
        );
    }

    public function getImmutableConfiguration(array $componentVariation, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($componentVariation, $props);

        $ret['layout-grid'] = $this->getProp($componentVariation, $props, 'layout-grid');

        // Comment Leo 03/07/2017: move the 'row' class out of the .tmpl, so it can be converted to style for the automatedemails
        $ret[GD_JS_CLASSES]['layoutgrid-wrapper'] = 'row';

        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        $this->setProp($componentVariation, $props, 'layout-grid', $this->getLayoutGrid($componentVariation, $props));

        // Needed for the automated emails
        $this->appendProp($componentVariation, $props, 'class', 'scroll-elem');

        // Comment Leo 03/07/2017: if the layout-grid has a class, add it to the module class
        // This is done so that the name of the class can be converted to style, for the automatedemails
        if ($layout_grid = $this->getProp($componentVariation, $props, 'layout-grid')) {
            if ($class = $layout_grid['class']) {
                $this->appendProp($componentVariation, $props, 'class', $class);
            }
        }

        parent::initModelProps($componentVariation, $props);
    }
}
