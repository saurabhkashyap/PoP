<?php

class GD_URE_Module_Processor_CustomContents extends PoP_Module_Processor_ContentsBase
{
    public final const COMPONENT_URE_CONTENT_MEMBER = 'ure-content-member';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_URE_CONTENT_MEMBER,
        );
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_URE_CONTENT_MEMBER:
                return [GD_URE_Module_Processor_CustomContentInners::class, GD_URE_Module_Processor_CustomContentInners::COMPONENT_URE_CONTENTINNER_MEMBER];
        }

        return parent::getInnerSubcomponent($component);
    }
}


