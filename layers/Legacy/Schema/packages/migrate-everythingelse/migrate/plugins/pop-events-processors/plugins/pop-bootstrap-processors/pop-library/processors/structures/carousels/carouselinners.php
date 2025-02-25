<?php

class GD_EM_Module_Processor_CustomCarouselInners extends PoP_Module_Processor_CarouselInnersBase
{
    public final const COMPONENT_CAROUSELINNER_EVENTS = 'carouselinner-events';
    public final const COMPONENT_CAROUSELINNER_AUTHOREVENTS = 'carouselinner-authorevents';
    public final const COMPONENT_CAROUSELINNER_TAGEVENTS = 'carouselinner-tagevents';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_CAROUSELINNER_EVENTS,
            self::COMPONENT_CAROUSELINNER_AUTHOREVENTS,
            self::COMPONENT_CAROUSELINNER_TAGEVENTS,
        );
    }

    public function getLayoutGrid(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_CAROUSELINNER_EVENTS:
            case self::COMPONENT_CAROUSELINNER_AUTHOREVENTS:
            case self::COMPONENT_CAROUSELINNER_TAGEVENTS:
                return \PoP\Root\App::applyFilters(
                    'GD_EM_Module_Processor_CustomCarouselInners:grid',
                    array(
                        'row-items' => 1,
                        'class' => 'col-sm-12',
                        'divider' => 3,
                    )
                );
        }

        return parent::getLayoutGrid($component, $props);
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getLayoutSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_CAROUSELINNER_EVENTS:
            case self::COMPONENT_CAROUSELINNER_AUTHOREVENTS:
            case self::COMPONENT_CAROUSELINNER_TAGEVENTS:
                // Allow to override. Eg: TPP Debate needs a different format
                $layout = \PoP\Root\App::applyFilters(
                    'GD_EM_Module_Processor_CustomCarouselInners:layout', 
                    [GD_EM_Module_Processor_CustomPreviewPostLayouts::class, GD_EM_Module_Processor_CustomPreviewPostLayouts::COMPONENT_LAYOUT_PREVIEWPOST_EVENT_LIST], 
                    $component
                );
                $ret[] = $layout;
                break;
        }

        return $ret;
    }
}


