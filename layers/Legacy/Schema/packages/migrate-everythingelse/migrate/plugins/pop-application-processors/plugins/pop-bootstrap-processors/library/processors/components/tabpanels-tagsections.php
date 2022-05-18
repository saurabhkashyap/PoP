<?php

class PoP_Module_Processor_TagSectionTabPanelComponents extends PoP_Module_Processor_TagSectionTabPanelComponentsBase
{
    public final const MODULE_TABPANEL_TAGCONTENT = 'tabpanel-tagcontent';
    public final const MODULE_TABPANEL_TAGPOSTS = 'tabpanel-tagposts';
    public final const MODULE_TABPANEL_TAGSUBSCRIBERS = 'tabpanel-tagsubscribers';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_TABPANEL_TAGCONTENT],
            [self::class, self::MODULE_TABPANEL_TAGPOSTS],
            [self::class, self::MODULE_TABPANEL_TAGSUBSCRIBERS],
        );
    }

    protected function getDefaultActivepanelFormat(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_TABPANEL_TAGSUBSCRIBERS:
                return PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_TAGUSERS);
        }

        return parent::getDefaultActivepanelFormat($componentVariation);
    }

    public function getPanelSubmodules(array $componentVariation)
    {
        $ret = parent::getPanelSubmodules($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_TABPANEL_TAGCONTENT:
                $ret = array_merge(
                    $ret,
                    array(
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_SIMPLEVIEW],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_FULLVIEW],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_DETAILS],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_THUMBNAIL],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_LIST],
                    )
                );
                break;

            case self::MODULE_TABPANEL_TAGPOSTS:
                $ret = array_merge(
                    $ret,
                    array(
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_SIMPLEVIEW],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_FULLVIEW],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_DETAILS],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_THUMBNAIL],
                        [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_LIST],
                    )
                );
                break;

            case self::MODULE_TABPANEL_TAGSUBSCRIBERS:
                $ret = array_merge(
                    $ret,
                    array(
                        [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_FULLVIEW],
                        [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_DETAILS],
                        [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_THUMBNAIL],
                        [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_LIST],
                    )
                );
                break;
        }

        // Allow Events Manager to add the Map format
        $ret = \PoP\Root\App::applyFilters('PoP_Module_Processor_TagSectionTabPanelComponents:modules', $ret, $componentVariation);

        return $ret;
    }

    public function getPanelHeaders(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_TABPANEL_TAGCONTENT:
                $ret = array(
                    [
                        'header-submodule' => [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_SIMPLEVIEW],
                        'subheader-submodules' =>  array(
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_SIMPLEVIEW],
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_FULLVIEW],
                        ),
                    ],
                    [
                        'header-submodule' => [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_LIST],
                        'subheader-submodules' =>  array(
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_DETAILS],
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_THUMBNAIL],
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGCONTENT_SCROLL_LIST],
                        ),
                    ],
                );
                break;

            case self::MODULE_TABPANEL_TAGPOSTS:
                $ret = array(
                    [
                        'header-submodule' => [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_SIMPLEVIEW],
                        'subheader-submodules' =>  array(
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_SIMPLEVIEW],
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_FULLVIEW],
                        ),
                    ],
                    [
                        'header-submodule' => [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_DETAILS],
                        'subheader-submodules' =>  array(
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_DETAILS],
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_THUMBNAIL],
                            [PoP_Blog_Module_Processor_CustomSectionDataloads::class, PoP_Blog_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGPOSTS_SCROLL_LIST],
                        ),
                    ],
                );
                break;

            case self::MODULE_TABPANEL_TAGSUBSCRIBERS:
                $ret = array(
                    [
                        'header-submodule' => [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_FULLVIEW],
                    ],
                    [
                        'header-submodule' => [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_DETAILS],
                        'subheader-submodules' =>  array(
                            [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_DETAILS],
                            [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_THUMBNAIL],
                            [PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::class, PoP_SocialNetwork_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_TAGSUBSCRIBERS_SCROLL_LIST],
                        ),
                    ],
                );
                break;
        }

        if ($ret) {
            return \PoP\Root\App::applyFilters('PoP_Module_Processor_TagSectionTabPanelComponents:panel_headers', $ret, $componentVariation);
        }

        return parent::getPanelHeaders($componentVariation, $props);
    }
}


