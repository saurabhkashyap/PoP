<?php

class PoP_AddPostLinks_Module_Processor_LayoutWrappers extends PoP_Module_Processor_ConditionWrapperBase
{
    public final const COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMEVISIBLE = 'layoutwrapper-addpostlinks-linkframevisible';
    public final const COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMECOLLAPSED = 'layoutwrapper-addpostlinks-linkframecollapsed';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMEVISIBLE,
            self::COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMECOLLAPSED,
        );
    }

    public function getConditionSucceededSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getConditionSucceededSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMEVISIBLE:
                $ret[] = [PoP_AddPostLinks_Module_Processor_LinkFrameLayouts::class, PoP_AddPostLinks_Module_Processor_LinkFrameLayouts::COMPONENT_ADDPOSTLINKS_LAYOUT_LINKFRAMEVISIBLE];
                break;

            case self::COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMECOLLAPSED:
                $ret[] = [PoP_AddPostLinks_Module_Processor_LinkFrameLayouts::class, PoP_AddPostLinks_Module_Processor_LinkFrameLayouts::COMPONENT_ADDPOSTLINKS_LAYOUT_LINKFRAMECOLLAPSED];
                break;
        }

        return $ret;
    }

    public function getConditionField(\PoP\ComponentModel\Component\Component $component): ?string
    {
        switch ($component->name) {
            case self::COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMEVISIBLE:
            case self::COMPONENT_ADDPOSTLINKS_LAYOUTWRAPPER_LINKFRAMECOLLAPSED:
                return 'hasLink';
        }

        return null;
    }
}



