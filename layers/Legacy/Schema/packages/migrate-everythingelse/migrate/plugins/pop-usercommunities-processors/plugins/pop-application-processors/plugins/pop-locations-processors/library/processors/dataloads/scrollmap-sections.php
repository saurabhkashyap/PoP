<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;
use PoPCMSSchema\Users\TypeResolvers\ObjectType\UserObjectTypeResolver;

class PoP_UserCommunities_ComponentProcessor_CustomScrollMapSectionDataloads extends GD_EM_Module_Processor_ScrollMapDataloadsBase
{
    public final const COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP = 'dataload-communities-scrollmap';
    public final const COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP = 'dataload-authormembers-scrollmap';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP,
            self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP,
        );
    }

    public function getRelevantRoute(\PoP\ComponentModel\Component\Component $component, array &$props): ?string
    {
        return match($component->name) {
            self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP => POP_USERCOMMUNITIES_ROUTE_MEMBERS,
            self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP => POP_USERCOMMUNITIES_ROUTE_COMMUNITIES,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    public function getInnerSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        $inner_components = array(
            self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP => [PoP_UserCommunities_ComponentProcessor_CustomScrollMapSections::class, PoP_UserCommunities_ComponentProcessor_CustomScrollMapSections::COMPONENT_SCROLLMAP_COMMUNITIES_SCROLLMAP],
            self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP => [PoP_UserCommunities_ComponentProcessor_CustomScrollMapSections::class, PoP_UserCommunities_ComponentProcessor_CustomScrollMapSections::COMPONENT_SCROLLMAP_AUTHORCOMMUNITYMEMBERS_SCROLLMAP],
        );

        return $inner_components[$component->name] ?? null;
    }

    public function getFilterSubcomponent(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\Component\Component
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP:
                return [GD_URE_Module_Processor_CustomFilters::class, GD_URE_Module_Processor_CustomFilters::COMPONENT_FILTER_COMMUNITIES];

            case self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP:
                return [PoP_Module_Processor_CustomFilters::class, PoP_Module_Processor_CustomFilters::COMPONENT_FILTER_AUTHORCOMMUNITYMEMBERS];
        }

        return parent::getFilterSubcomponent($component);
    }

    public function getFormat(\PoP\ComponentModel\Component\Component $component): ?string
    {
        $maps = array(
            self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP,
            self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP,
        );
        if (in_array($component, $maps)) {
            $format = POP_FORMAT_MAP;
        }

        return $format ?? parent::getFormat($component);
    }

    // public function getNature(\PoP\ComponentModel\Component\Component $component)
    // {
    //     switch ($component->name) {
    //         case self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP:
    //             return UserRequestNature::USER;
    //     }

    //     return parent::getNature($component);
    // }
    protected function getImmutableDataloadQueryArgs(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableDataloadQueryArgs($component, $props);

        switch ($component->name) {
            case self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_CAROUSEL:
                $ret['orderby'] = NameResolverFacade::getInstance()->getName('popcms:dbcolumn:orderby:users:registrationdate');
                $ret['order'] = 'DESC';
                break;
            case self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP:
                $ret['role'] = GD_URE_ROLE_COMMUNITY;
                break;
        }

        return $ret;
    }

    protected function getMutableonrequestDataloadQueryArgs(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getMutableonrequestDataloadQueryArgs($component, $props);

        switch ($component->name) {
         // Members of the Community
            case self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP:
                $author = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                // If the profile is not a community, then return no users at all (Eg: a community opting out from having members)
                if (gdUreIsCommunity($author)) {
                    URE_CommunityUtils::addDataloadqueryargsCommunitymembers($ret, $author);
                }
                break;
        }

        return $ret;
    }

    public function getRelationalTypeResolver(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component->name) {
            case self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP:
            case self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP:
                return $this->instanceManager->getInstance(UserObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($component);
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
         // Members of the Community
            case self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP:
                $author = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                // If the profile is not a community, then return no users at all (Eg: a community opting out from having members)
                if (!gdUreIsCommunity($author)) {
                    $this->setProp($component, $props, 'skip-data-load', true);
                }
                break;
        }

        switch ($component->name) {
            case self::COMPONENT_DATALOAD_AUTHORCOMMUNITYMEMBERS_SCROLLMAP:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('members', 'poptheme-wassup'));
                break;

            case self::COMPONENT_DATALOAD_COMMUNITIES_SCROLLMAP:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('communities', 'poptheme-wassup'));
                break;
        }

        parent::initModelProps($component, $props);
    }
}

