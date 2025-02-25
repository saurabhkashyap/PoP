<?php

abstract class PoP_Module_Processor_StanceReferencesScriptFrameLayoutsBase extends PoP_Module_Processor_ScriptFrameLayoutsBase
{
    public function doAppend(\PoP\ComponentModel\Component\Component $component)
    {
        return true;
    }

    public function getScriptSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        return $this->doAppend($component) ? 
        	[UserStance_Module_Processor_ScriptsLayouts::class, UserStance_Module_Processor_ScriptsLayouts::COMPONENT_SCRIPT_STANCES] : 
        	[UserStance_Module_Processor_ScriptsLayouts::class, UserStance_Module_Processor_ScriptsLayouts::COMPONENT_SCRIPT_STANCESEMPTY];
    }
}
