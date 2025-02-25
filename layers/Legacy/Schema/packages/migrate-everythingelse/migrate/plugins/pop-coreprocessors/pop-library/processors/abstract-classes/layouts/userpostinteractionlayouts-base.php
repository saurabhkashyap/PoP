<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;

abstract class PoP_Module_Processor_UserPostInteractionLayoutsBase extends PoPEngine_QueryDataComponentProcessorBase
{
    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);
        if ($layouts = $this->getLayoutSubcomponents($component)) {
            $ret = array_merge(
                $ret,
                $layouts
            );
        }

        if ($user_avatar = $this->getLoggedinUseravatarSubcomponent($component)) {
            $ret[] = $user_avatar;
        }
        return $ret;
    }

    public function getTemplateResource(\PoP\ComponentModel\Component\Component $component, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_LAYOUT_USERPOSTINTERACTION];
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        return array();
    }

    public function getLoggedinUseravatarSubcomponent()
    {
        if (defined('POP_USERAVATARPROCESSORS_INITIALIZED')) {
            return [PoP_Module_Processor_LoggedInUserAvatars::class, PoP_Module_Processor_LoggedInUserAvatars::COMPONENT_LAYOUT_LOGGEDINUSERAVATAR];
        }

        return null;
    }

    public function getStyleClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        return '';
    }

    public function addUseravatar(\PoP\ComponentModel\Component\Component $component, array &$props)
    {

        // If the plugin to create avatar is defined, then enable it
        return PoP_Application_ConfigurationUtils::useUseravatar();
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();

        if ($layouts = $this->getLayoutSubcomponents($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['layouts'] = array_map(
                \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName(...),
                $layouts
            );
        }

        if ($user_avatar = $this->getLoggedinUseravatarSubcomponent($component)) {
            $ret[GD_JS_SUBCOMPONENTOUTPUTNAMES]['useravatar'] = \PoP\ComponentModel\Facades\ComponentHelpers\ComponentHelpersFacade::getInstance()->getComponentOutputName($user_avatar);
        }

        $ret['add-useravatar'] = $this->addUseravatar($component, $props);

        return $ret;
    }

    public function getJsmethods(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        $ret = parent::getJsmethods($component, $props);

        if ($this->addUseravatar($component, $props)) {
            $this->addJsmethod($ret, 'loadLoggedInUserAvatar', 'useravatar');
        }

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        $this->appendProp($component, $props, 'class', 'frame-addcomment');

        // Add the style for the frame
        if ($classs = $this->getStyleClass($component, $props)) {
            $this->appendProp($component, $props, 'class', $classs);
        }

        parent::initModelProps($component, $props);
    }
}
