<?php

class GD_URE_Module_Processor_CustomScrollInners extends PoP_Module_Processor_ScrollInnersBase
{
    public final const COMPONENT_SCROLLINNER_ORGANIZATIONS_DETAILS = 'scrollinner-organizations-details';
    public final const COMPONENT_SCROLLINNER_INDIVIDUALS_DETAILS = 'scrollinner-individuals-details';
    public final const COMPONENT_SCROLLINNER_ORGANIZATIONS_FULLVIEW = 'scrollinner-organizations-fullview';
    public final const COMPONENT_SCROLLINNER_INDIVIDUALS_FULLVIEW = 'scrollinner-individuals-fullview';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_SCROLLINNER_ORGANIZATIONS_DETAILS,
            self::COMPONENT_SCROLLINNER_INDIVIDUALS_DETAILS,
            self::COMPONENT_SCROLLINNER_ORGANIZATIONS_FULLVIEW,
            self::COMPONENT_SCROLLINNER_INDIVIDUALS_FULLVIEW,
        );
    }

    public function getLayoutGrid(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_SCROLLINNER_ORGANIZATIONS_DETAILS:
            case self::COMPONENT_SCROLLINNER_INDIVIDUALS_DETAILS:
            case self::COMPONENT_SCROLLINNER_ORGANIZATIONS_FULLVIEW:
            case self::COMPONENT_SCROLLINNER_INDIVIDUALS_FULLVIEW:
                return array(
                    'row-items' => 1,
                    'class' => 'col-sm-12'
                );
        }

        return parent::getLayoutGrid($component, $props);
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getLayoutSubcomponents($component);

        $layouts = array(
            self::COMPONENT_SCROLLINNER_ORGANIZATIONS_DETAILS => [GD_URE_Module_Processor_CustomPreviewUserLayouts::class, GD_URE_Module_Processor_CustomPreviewUserLayouts::COMPONENT_LAYOUT_PREVIEWUSER_ORGANIZATION_DETAILS],
            self::COMPONENT_SCROLLINNER_INDIVIDUALS_DETAILS => [GD_URE_Module_Processor_CustomPreviewUserLayouts::class, GD_URE_Module_Processor_CustomPreviewUserLayouts::COMPONENT_LAYOUT_PREVIEWUSER_INDIVIDUAL_DETAILS],

            self::COMPONENT_SCROLLINNER_ORGANIZATIONS_FULLVIEW => [GD_URE_Module_Processor_CustomFullUserLayouts::class, GD_URE_Module_Processor_CustomFullUserLayouts::COMPONENT_LAYOUT_FULLUSER_ORGANIZATION],
            self::COMPONENT_SCROLLINNER_INDIVIDUALS_FULLVIEW => [GD_URE_Module_Processor_CustomFullUserLayouts::class, GD_URE_Module_Processor_CustomFullUserLayouts::COMPONENT_LAYOUT_FULLUSER_INDIVIDUAL],
        );

        if ($layout = $layouts[$component->name] ?? null) {
            $ret[] = $layout;
        }

        return $ret;
    }
}


