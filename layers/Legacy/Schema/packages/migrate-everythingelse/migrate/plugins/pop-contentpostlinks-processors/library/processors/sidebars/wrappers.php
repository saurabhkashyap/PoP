<?php

class PoP_ContentPostLinks_Module_Processor_WidgetWrappers extends PoP_Module_Processor_ConditionWrapperBase
{
    public final const COMPONENT_LAYOUTWRAPPER_LINK_CATEGORIES = 'layoutwrapper-link-categories';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUTWRAPPER_LINK_CATEGORIES,
        );
    }

    public function getConditionSucceededSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getConditionSucceededSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_LAYOUTWRAPPER_LINK_CATEGORIES:
                $ret[] = [PoP_ContentPostLinks_Module_Processor_CategoriesLayouts::class, PoP_ContentPostLinks_Module_Processor_CategoriesLayouts::COMPONENT_LAYOUT_LINK_CATEGORIES];
                break;
        }

        return $ret;
    }

    public function getConditionField(\PoP\ComponentModel\Component\Component $component): ?string
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUTWRAPPER_LINK_CATEGORIES:
                return 'hasLinkCategories';
        }

        return null;
    }
}



