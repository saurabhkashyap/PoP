<?php

class PoP_Module_Processor_LoginGroups extends PoP_Module_Processor_MultiplesBase
{
    public final const COMPONENT_GROUP_LOGIN = 'group-login';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_GROUP_LOGIN,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_GROUP_LOGIN:
                $ret[] = [PoP_UserLogin_Module_Processor_Blocks::class, PoP_UserLogin_Module_Processor_Blocks::COMPONENT_BLOCK_LOGIN];
                $ret = array_merge(
                    $ret,
                    PoP_Module_Processor_UserAccountUtils::getLoginComponents()
                );
                break;
        }

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_GROUP_LOGIN:
                $this->appendProp($component, $props, 'class', 'blockgroup-login');

                // Make the Login Block and others show the submenu
                foreach ($this->getSubcomponents($component) as $subcomponent) {
                    $this->setProp([$subcomponent], $props, 'show-submenu', true);

                    // Allow to set $props for the extra blocks. Eg: WSL setting the loginBlock for setting the disabled layer
                    $hooks = \PoP\Root\App::applyFilters(
                        'PoP_Module_Processor_LoginGroups:props:hooks',
                        array()
                    );
                    foreach ($hooks as $hook) {
                        $hook->setModelProps($component, $props, $this);
                    }
                }
                break;
        }

        parent::initModelProps($component, $props);
    }
}


