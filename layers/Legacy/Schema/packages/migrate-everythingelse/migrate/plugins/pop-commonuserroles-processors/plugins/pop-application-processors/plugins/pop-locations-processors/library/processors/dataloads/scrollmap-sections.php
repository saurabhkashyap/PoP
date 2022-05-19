<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\Users\TypeResolvers\ObjectType\UserObjectTypeResolver;

class GD_URE_Module_Processor_CustomScrollMapSectionDataloads extends GD_EM_Module_Processor_ScrollMapDataloadsBase
{
    public final const COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP = 'dataload-organizations-scrollmap';
    public final const COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP = 'dataload-individuals-scrollmap';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP],
            [self::class, self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP],
        );
    }

    public function getRelevantRoute(array $component, array &$props): ?string
    {
        return match($component[1]) {
            self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP => POP_COMMONUSERROLES_ROUTE_INDIVIDUALS,
            self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP => POP_COMMONUSERROLES_ROUTE_ORGANIZATIONS,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    public function getInnerSubcomponent(array $component)
    {
        $inner_components = array(
            self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP => [GD_URE_Module_Processor_CustomScrollMapSections::class, GD_URE_Module_Processor_CustomScrollMapSections::COMPONENT_SCROLLMAP_ORGANIZATIONS_SCROLLMAP],
            self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP => [GD_URE_Module_Processor_CustomScrollMapSections::class, GD_URE_Module_Processor_CustomScrollMapSections::COMPONENT_SCROLLMAP_INDIVIDUALS_SCROLLMAP],
        );

        return $inner_components[$component[1]] ?? null;
    }

    public function getFilterSubcomponent(array $component): ?array
    {
        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP:
                return [PoP_CommonUserRoles_Module_Processor_CustomFilters::class, PoP_CommonUserRoles_Module_Processor_CustomFilters::COMPONENT_FILTER_INDIVIDUALS];

            case self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP:
                return [PoP_CommonUserRoles_Module_Processor_CustomFilters::class, PoP_CommonUserRoles_Module_Processor_CustomFilters::COMPONENT_FILTER_ORGANIZATIONS];
        }

        return parent::getFilterSubcomponent($component);
    }

    public function getFormat(array $component): ?string
    {
        $maps = array(
            [self::class, self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP],
            [self::class, self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP],
        );
        if (in_array($component, $maps)) {
            $format = POP_FORMAT_MAP;
        }

        return $format ?? parent::getFormat($component);
    }

    protected function getImmutableDataloadQueryArgs(array $component, array &$props): array
    {
        $ret = parent::getImmutableDataloadQueryArgs($component, $props);

        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP:
                $ret['role'] = GD_URE_ROLE_ORGANIZATION;
                break;

            case self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP:
                $ret['role'] = GD_URE_ROLE_INDIVIDUAL;
                break;
        }

        return $ret;
    }

    public function getRelationalTypeResolver(array $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP:
            case self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP:
                return $this->instanceManager->getInstance(UserObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($component);
    }

    public function initModelProps(array $component, array &$props): void
    {
        switch ($component[1]) {
            case self::COMPONENT_DATALOAD_ORGANIZATIONS_SCROLLMAP:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('organizations', 'poptheme-wassup'));
                break;

            case self::COMPONENT_DATALOAD_INDIVIDUALS_SCROLLMAP:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::COMPONENT_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', TranslationAPIFacade::getInstance()->__('individuals', 'poptheme-wassup'));
                break;
        }
        parent::initModelProps($component, $props);
    }
}



