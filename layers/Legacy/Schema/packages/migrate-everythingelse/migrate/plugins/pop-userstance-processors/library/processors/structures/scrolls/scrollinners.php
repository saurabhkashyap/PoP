<?php

class UserStance_Module_Processor_CustomScrollInners extends PoP_Module_Processor_ScrollInnersBase
{
    public final const COMPONENT_SCROLLINNER_MYSTANCES_FULLVIEWPREVIEW = 'scrollinner-mystance-fullviewpreview';
    public final const COMPONENT_SCROLLINNER_STANCES_NAVIGATOR = 'scrollinner-stances-navigator';
    public final const COMPONENT_SCROLLINNER_STANCES_ADDONS = 'scrollinner-stances-addons';
    public final const COMPONENT_SCROLLINNER_STANCES_FULLVIEW = 'scrollinner-stances-fullview';
    public final const COMPONENT_SCROLLINNER_STANCES_THUMBNAIL = 'scrollinner-stances-thumbnail';
    public final const COMPONENT_SCROLLINNER_STANCES_LIST = 'scrollinner-stances-list';
    public final const COMPONENT_SCROLLINNER_AUTHORSTANCES_FULLVIEW = 'scrollinner-authorstances-fullview';
    public final const COMPONENT_SCROLLINNER_AUTHORSTANCES_THUMBNAIL = 'scrollinner-authorstances-thumbnail';
    public final const COMPONENT_SCROLLINNER_AUTHORSTANCES_LIST = 'scrollinner-authorstances-list';
    public final const COMPONENT_SCROLLINNER_SINGLERELATEDSTANCECONTENT_FULLVIEW = 'scrollinner-singlerelatedstancecontent-fullview';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_SCROLLINNER_MYSTANCES_FULLVIEWPREVIEW,
            self::COMPONENT_SCROLLINNER_STANCES_NAVIGATOR,
            self::COMPONENT_SCROLLINNER_STANCES_ADDONS,
            self::COMPONENT_SCROLLINNER_STANCES_FULLVIEW,
            self::COMPONENT_SCROLLINNER_STANCES_THUMBNAIL,
            self::COMPONENT_SCROLLINNER_STANCES_LIST,
            self::COMPONENT_SCROLLINNER_AUTHORSTANCES_FULLVIEW,
            self::COMPONENT_SCROLLINNER_AUTHORSTANCES_THUMBNAIL,
            self::COMPONENT_SCROLLINNER_AUTHORSTANCES_LIST,
            self::COMPONENT_SCROLLINNER_SINGLERELATEDSTANCECONTENT_FULLVIEW,
        );
    }

    public function getLayoutGrid(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_SCROLLINNER_STANCES_THUMBNAIL:
            case self::COMPONENT_SCROLLINNER_AUTHORSTANCES_THUMBNAIL:
                // Allow ThemeStyle Expansive to override the grid
                return \PoP\Root\App::applyFilters(
                    POP_HOOK_SCROLLINNER_THUMBNAIL_GRID,
                    array(
                        'row-items' => 2,
                        'class' => 'col-xsm-6'
                    )
                );

            case self::COMPONENT_SCROLLINNER_MYSTANCES_FULLVIEWPREVIEW:
            case self::COMPONENT_SCROLLINNER_STANCES_NAVIGATOR:
            case self::COMPONENT_SCROLLINNER_STANCES_ADDONS:
            case self::COMPONENT_SCROLLINNER_STANCES_FULLVIEW:
            case self::COMPONENT_SCROLLINNER_STANCES_LIST:
            case self::COMPONENT_SCROLLINNER_AUTHORSTANCES_FULLVIEW:
            case self::COMPONENT_SCROLLINNER_AUTHORSTANCES_LIST:
            case self::COMPONENT_SCROLLINNER_SINGLERELATEDSTANCECONTENT_FULLVIEW:
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
            self::COMPONENT_SCROLLINNER_STANCES_NAVIGATOR => [UserStance_Module_Processor_CustomPreviewPostLayouts::class, UserStance_Module_Processor_CustomPreviewPostLayouts::COMPONENT_LAYOUT_PREVIEWPOST_STANCE_NAVIGATOR],
            self::COMPONENT_SCROLLINNER_STANCES_ADDONS => [UserStance_Module_Processor_CustomPreviewPostLayouts::class, UserStance_Module_Processor_CustomPreviewPostLayouts::COMPONENT_LAYOUT_PREVIEWPOST_STANCE_CONTENTAUTHORREFERENCED],
            self::COMPONENT_SCROLLINNER_STANCES_FULLVIEW => [UserStance_Module_Processor_CustomFullViewLayouts::class, UserStance_Module_Processor_CustomFullViewLayouts::COMPONENT_LAYOUT_FULLVIEW_STANCE],
            self::COMPONENT_SCROLLINNER_STANCES_THUMBNAIL => [UserStance_Module_Processor_CustomPreviewPostLayouts::class, UserStance_Module_Processor_CustomPreviewPostLayouts::COMPONENT_LAYOUT_PREVIEWPOST_STANCE_THUMBNAIL],
            self::COMPONENT_SCROLLINNER_STANCES_LIST => [UserStance_Module_Processor_CustomPreviewPostLayouts::class, UserStance_Module_Processor_CustomPreviewPostLayouts::COMPONENT_LAYOUT_PREVIEWPOST_STANCE_CONTENTAUTHORREFERENCED],
            self::COMPONENT_SCROLLINNER_AUTHORSTANCES_FULLVIEW => [UserStance_Module_Processor_CustomFullViewLayouts::class, UserStance_Module_Processor_CustomFullViewLayouts::COMPONENT_LAYOUT_FULLVIEW_STANCE],
            self::COMPONENT_SCROLLINNER_AUTHORSTANCES_THUMBNAIL => [UserStance_Module_Processor_CustomPreviewPostLayouts::class, UserStance_Module_Processor_CustomPreviewPostLayouts::COMPONENT_LAYOUT_PREVIEWPOST_STANCE_THUMBNAIL],
            self::COMPONENT_SCROLLINNER_AUTHORSTANCES_LIST => [UserStance_Module_Processor_CustomPreviewPostLayouts::class, UserStance_Module_Processor_CustomPreviewPostLayouts::COMPONENT_LAYOUT_PREVIEWPOST_STANCE_CONTENTAUTHORREFERENCED],
            self::COMPONENT_SCROLLINNER_MYSTANCES_FULLVIEWPREVIEW => [UserStance_Module_Processor_CustomFullViewLayouts::class, UserStance_Module_Processor_CustomFullViewLayouts::COMPONENT_LAYOUT_FULLVIEW_STANCE],
            self::COMPONENT_SCROLLINNER_SINGLERELATEDSTANCECONTENT_FULLVIEW => [UserStance_Module_Processor_CustomFullViewLayouts::class, UserStance_Module_Processor_CustomFullViewLayouts::COMPONENT_LAYOUT_FULLVIEW_STANCE],
        );

        if ($layout = $layouts[$component->name] ?? null) {
            $ret[] = $layout;
        }

        return $ret;
    }
}


