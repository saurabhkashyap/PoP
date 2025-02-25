<?php

class PoP_Module_Processor_SocialMediaMultipleComponents extends PoP_Module_Processor_MultiplesBase
{
    public final const COMPONENT_MULTICOMPONENT_POSTSOCIALMEDIA = 'multicomponent-post-sm';
    public final const COMPONENT_MULTICOMPONENT_USERSOCIALMEDIA = 'multicomponent-user-sm';
    public final const COMPONENT_MULTICOMPONENT_TAGSOCIALMEDIA = 'multicomponent-tag-sm';
    public final const COMPONENT_MULTICOMPONENT_POSTSECINTERACTIONS = 'multicomponent-postsecinteractions';
    public final const COMPONENT_MULTICOMPONENT_USERSECINTERACTIONS = 'multicomponent-usersecinteractions';
    public final const COMPONENT_MULTICOMPONENT_TAGSECINTERACTIONS = 'multicomponent-tagsecinteractions';
    public final const COMPONENT_MULTICOMPONENT_POSTOPTIONS = 'multicomponent-postoptions';
    public final const COMPONENT_MULTICOMPONENT_USEROPTIONS = 'multicomponent-useroptions';
    public final const COMPONENT_MULTICOMPONENT_TAGOPTIONS = 'multicomponent-tagoptions';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_MULTICOMPONENT_POSTSOCIALMEDIA,
            self::COMPONENT_MULTICOMPONENT_USERSOCIALMEDIA,
            self::COMPONENT_MULTICOMPONENT_TAGSOCIALMEDIA,
            self::COMPONENT_MULTICOMPONENT_POSTSECINTERACTIONS,
            self::COMPONENT_MULTICOMPONENT_USERSECINTERACTIONS,
            self::COMPONENT_MULTICOMPONENT_TAGSECINTERACTIONS,
            self::COMPONENT_MULTICOMPONENT_POSTOPTIONS,
            self::COMPONENT_MULTICOMPONENT_USEROPTIONS,
            self::COMPONENT_MULTICOMPONENT_TAGOPTIONS,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        $components = array();
        switch ($component->name) {
            case self::COMPONENT_MULTICOMPONENT_POSTSOCIALMEDIA:
            case self::COMPONENT_MULTICOMPONENT_USERSOCIALMEDIA:
            case self::COMPONENT_MULTICOMPONENT_TAGSOCIALMEDIA:
                break;

            case self::COMPONENT_MULTICOMPONENT_POSTSECINTERACTIONS:
                $components[] = [PoP_Module_Processor_Buttons::class, PoP_Module_Processor_Buttons::COMPONENT_BUTTON_PRINT_SOCIALMEDIA];
                break;

            case self::COMPONENT_MULTICOMPONENT_USERSECINTERACTIONS:
                $components[] = [PoP_Module_Processor_Buttons::class, PoP_Module_Processor_Buttons::COMPONENT_BUTTON_PRINT_SOCIALMEDIA];
                break;

            case self::COMPONENT_MULTICOMPONENT_TAGSECINTERACTIONS:
                $components[] = [PoP_Module_Processor_Buttons::class, PoP_Module_Processor_Buttons::COMPONENT_BUTTON_PRINT_SOCIALMEDIA];
                break;

            case self::COMPONENT_MULTICOMPONENT_POSTOPTIONS:
                $components[] = self::COMPONENT_MULTICOMPONENT_POSTSOCIALMEDIA;
                $components[] = self::COMPONENT_MULTICOMPONENT_POSTSECINTERACTIONS;
                break;

            case self::COMPONENT_MULTICOMPONENT_USEROPTIONS:
                $components[] = self::COMPONENT_MULTICOMPONENT_USERSOCIALMEDIA;
                $components[] = self::COMPONENT_MULTICOMPONENT_USERSECINTERACTIONS;
                break;

            case self::COMPONENT_MULTICOMPONENT_TAGOPTIONS:
                $components[] = self::COMPONENT_MULTICOMPONENT_TAGSOCIALMEDIA;
                $components[] = self::COMPONENT_MULTICOMPONENT_TAGSECINTERACTIONS;
                break;
        }

        // Allow PoP Generic Forms Processors to add modules
        $components = \PoP\Root\App::applyFilters(
            'PoP_Module_Processor_SocialMediaMultipleComponents:modules',
            $components,
            $component
        );
        $ret = array_merge(
            $ret,
            $components
        );

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_MULTICOMPONENT_POSTSOCIALMEDIA:
            case self::COMPONENT_MULTICOMPONENT_USERSOCIALMEDIA:
            case self::COMPONENT_MULTICOMPONENT_TAGSOCIALMEDIA:
                $this->appendProp($component, $props, 'class', 'sm-group');
                break;

            case self::COMPONENT_MULTICOMPONENT_POSTSECINTERACTIONS:
            case self::COMPONENT_MULTICOMPONENT_USERSECINTERACTIONS:
            case self::COMPONENT_MULTICOMPONENT_TAGSECINTERACTIONS:
                $this->appendProp($component, $props, 'class', 'secinteractions-group');
                break;

            case self::COMPONENT_MULTICOMPONENT_POSTOPTIONS:
            case self::COMPONENT_MULTICOMPONENT_USEROPTIONS:
            case self::COMPONENT_MULTICOMPONENT_TAGOPTIONS:
                $this->appendProp($component, $props, 'class', 'options-group');
                foreach ($this->getSubcomponents($component) as $subcomponent) {
                    $this->appendProp([$subcomponent], $props, 'class', 'inline');
                }
                break;
        }

        parent::initModelProps($component, $props);
    }
}



