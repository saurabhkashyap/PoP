<?php
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;

abstract class PoP_Module_Processor_UserTypeaheadComponentLayoutsBase extends PoPEngine_QueryDataComponentProcessorBase
{
    public function getTemplateResource(\PoP\ComponentModel\Component\Component $component, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_LAYOUTUSER_TYPEAHEAD_COMPONENT];
    }

    /**
     * @todo Migrate from string to LeafComponentFieldNode
     *
     * @return \PoP\ComponentModel\GraphQLEngine\Model\ComponentModelSpec\LeafComponentFieldNode[]
     */
    public function getLeafComponentFieldNodes(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
    
        /* FIX THIS: 'url' */
        // is-community needed for the Community filter (it will print a checkbox with msg 'include members?')
        $data_fields = array('displayName', 'url', 'isCommunity');
        if (PoP_Application_ConfigurationUtils::useUseravatar()) {
            // Important: the TYPEAHEAD_COMPONENT should not have data-fields, because it doesn't apply to {{blockSettings.dataset}}
            // but it applies to Twitter Typeahead, which doesn't need these parameters, however these, here, upset the whole getDatasetComponentTreeSectionFlattenedDataProperties
            // To fix this, in self::COMPONENT_FORMINPUT_TYPEAHEAD data_properties we stop spreading down, so it never reaches below there to get further data-fields

            // Important: for Component the size is fixed! It can't be changed from 'avatar-40', because it is hardcoded
            // in layoutuser-typeahead-component.tmpl
            $avatar_size = GD_AVATAR_SIZE_40;
            $avatar_field = PoP_AvatarFoundationManagerFactory::getInstance()->getAvatarField($avatar_size);
            $data_fields[] = $avatar_field;
        }

        return $data_fields;
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        if (PoP_Application_ConfigurationUtils::useUseravatar()) {
            $avatar_size = GD_AVATAR_SIZE_40;
            $avatar_field = PoP_AvatarFoundationManagerFactory::getInstance()->getAvatarField($avatar_size);

            $ret['avatar'] = array(
                'name' => FieldQueryInterpreterFacade::getInstance()->getTargetObjectTypeUniqueFieldOutputKeys(
                $this->getProp($component, $props, 'succeeding-typeResolver'),
                $avatar_field),
                'size' => $avatar_size
            );
        }
        
        return $ret;
    }
}
