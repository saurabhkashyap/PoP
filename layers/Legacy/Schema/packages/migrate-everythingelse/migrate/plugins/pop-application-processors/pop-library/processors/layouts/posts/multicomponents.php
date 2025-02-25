<?php
use PoP\Application\Constants\Actions;
use PoP\ComponentModel\State\ApplicationState;

class Wassup_Module_Processor_MultipleComponentLayouts extends PoP_Module_Processor_MultiplesBase
{
    public final const COMPONENT_MULTICOMPONENT_USERHIGHLIGHTPOSTINTERACTION = 'multicomponent-userhighlightpostinteraction';
    public final const COMPONENT_MULTICOMPONENT_USERPOSTINTERACTION = 'multicomponent-userpostinteraction';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_MULTICOMPONENT_USERHIGHLIGHTPOSTINTERACTION,
            self::COMPONENT_MULTICOMPONENT_USERPOSTINTERACTION,
        );
    }

    protected function getUserpostinteractionLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $loadingLazy = in_array(Actions::LOADLAZY, \PoP\Root\App::getState('actions'));
        switch ($component->name) {
         // Highlights: it has a different set-up
            case self::COMPONENT_MULTICOMPONENT_USERHIGHLIGHTPOSTINTERACTION:
                $layouts = array(
                    [PoP_Module_Processor_CustomWrapperLayouts::class, PoP_Module_Processor_CustomWrapperLayouts::COMPONENT_LAYOUTWRAPPER_USERHIGHLIGHTPOSTINTERACTION],
                );
                if ($loadingLazy) {
                    $layouts[] = [PoP_Module_Processor_PostCommentSubcomponentLayouts::class, PoP_Module_Processor_PostCommentSubcomponentLayouts::COMPONENT_SUBCOMPONENT_POSTCOMMENTS];
                } else {
                    $layouts[] = [PoP_Module_Processor_CustomWrapperLayouts::class, PoP_Module_Processor_CustomWrapperLayouts::COMPONENT_CODEWRAPPER_LAZYLOADINGSPINNER];
                    $layouts[] = [PoP_Module_Processor_PostCommentSubcomponentLayouts::class, PoP_Module_Processor_PostCommentSubcomponentLayouts::COMPONENT_LAZYSUBCOMPONENT_NOHEADERPOSTCOMMENTS];
                }
                break;

            case self::COMPONENT_MULTICOMPONENT_USERPOSTINTERACTION:
                $layouts = array(
                    [PoP_Module_Processor_CustomWrapperLayouts::class, PoP_Module_Processor_CustomWrapperLayouts::COMPONENT_LAYOUTWRAPPER_USERPOSTINTERACTION],
                );
                if ($loadingLazy) {
                    $layouts[] = [PoP_Module_Processor_HighlightReferencedbyLayouts::class, PoP_Module_Processor_HighlightReferencedbyLayouts::COMPONENT_SUBCOMPONENT_HIGHLIGHTS];
                    $layouts[] = [PoP_Module_Processor_ReferencedbyLayouts::class, PoP_Module_Processor_ReferencedbyLayouts::COMPONENT_SUBCOMPONENT_REFERENCEDBY_FULLVIEW];
                    $layouts[] = [PoP_Module_Processor_PostCommentSubcomponentLayouts::class, PoP_Module_Processor_PostCommentSubcomponentLayouts::COMPONENT_SUBCOMPONENT_POSTCOMMENTS];
                } else {
                    $layouts[] = [PoP_Module_Processor_CustomWrapperLayouts::class, PoP_Module_Processor_CustomWrapperLayouts::COMPONENT_CODEWRAPPER_LAZYLOADINGSPINNER];
                    $layouts[] = [PoP_Module_Processor_HighlightReferencedbyLayouts::class, PoP_Module_Processor_HighlightReferencedbyLayouts::COMPONENT_LAZYSUBCOMPONENT_HIGHLIGHTS];
                    $layouts[] = [PoP_Module_Processor_ReferencedbyLayouts::class, PoP_Module_Processor_ReferencedbyLayouts::COMPONENT_LAZYSUBCOMPONENT_REFERENCEDBY];
                    $layouts[] = [PoP_Module_Processor_PostCommentSubcomponentLayouts::class, PoP_Module_Processor_PostCommentSubcomponentLayouts::COMPONENT_LAZYSUBCOMPONENT_POSTCOMMENTS];
                }
                break;
        }

        // Allow 3rd parties to modify the modules. Eg: for the TPP website we re-use the MESYM Theme but we modify some of its elements, eg: adding the "What do you think about TPP?" modules in the fullview templates
        return \PoP\Root\App::applyFilters(
            'Wassup_Module_Processor_MultipleComponentLayouts:userpostinteraction_layouts',
            $layouts,
            $component
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_MULTICOMPONENT_USERHIGHLIGHTPOSTINTERACTION:
            case self::COMPONENT_MULTICOMPONENT_USERPOSTINTERACTION:
                $ret = array_merge(
                    $ret,
                    $this->getUserpostinteractionLayoutSubcomponents($component)
                );
                break;
        }

        return $ret;
    }

    public function initModelProps(\PoP\ComponentModel\Component\Component $component, array &$props): void
    {
        switch ($component->name) {
            case self::COMPONENT_MULTICOMPONENT_USERHIGHLIGHTPOSTINTERACTION:
            case self::COMPONENT_MULTICOMPONENT_USERPOSTINTERACTION:
                $this->appendProp($component, $props, 'class', 'userpostinteraction-single');
                break;
        }

        parent::initModelProps($component, $props);
    }
}



