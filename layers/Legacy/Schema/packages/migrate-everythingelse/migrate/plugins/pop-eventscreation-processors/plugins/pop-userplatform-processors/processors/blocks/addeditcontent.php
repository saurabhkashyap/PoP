<?php

class GD_EM_Module_Processor_CreateUpdatePostBlocks extends PoP_Module_Processor_AddEditContentBlocksBase
{
    public final const COMPONENT_BLOCK_EVENT_UPDATE = 'block-event-update';
    public final const COMPONENT_BLOCK_EVENT_CREATE = 'block-event-create';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_BLOCK_EVENT_UPDATE,
            self::COMPONENT_BLOCK_EVENT_CREATE,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            self::COMPONENT_BLOCK_EVENT_CREATE => POP_EVENTSCREATION_ROUTE_ADDEVENT,
            self::COMPONENT_BLOCK_EVENT_UPDATE => POP_EVENTSCREATION_ROUTE_EDITEVENT,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    protected function getInnerSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getInnerSubcomponents($component);

        $block_inners = array(
            self::COMPONENT_BLOCK_EVENT_UPDATE => [GD_EM_Module_Processor_CreateUpdatePostDataloads::class, GD_EM_Module_Processor_CreateUpdatePostDataloads::COMPONENT_DATALOAD_EVENT_UPDATE],
            self::COMPONENT_BLOCK_EVENT_CREATE => [GD_EM_Module_Processor_CreateUpdatePostDataloads::class, GD_EM_Module_Processor_CreateUpdatePostDataloads::COMPONENT_DATALOAD_EVENT_CREATE],
        );
        if ($block_inner = $block_inners[$component->name] ?? null) {
            $ret[] = $block_inner;
        }

        return $ret;
    }

    protected function isCreate(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_EVENT_CREATE:
                return true;
        }

        return parent::isCreate($component);
    }
    protected function isUpdate(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_EVENT_UPDATE:
                return true;
        }

        return parent::isUpdate($component);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_BLOCK_EVENT_UPDATE:
            case self::COMPONENT_BLOCK_EVENT_CREATE:
                if (PoP_Application_Utils::getAddcontentTarget() == POP_TARGET_ADDONS) {
                    $this->appendProp($component, $props, 'class', 'addons-nocontrols');
                }
                break;
        }

        parent::initModelProps($component, $props);
    }
}



