<?php

class PoP_UserCommunities_Module_Processor_CustomCarouselInners extends PoP_Module_Processor_CarouselInnersBase
{
    public final const MODULE_CAROUSELINNER_AUTHORMEMBERS = 'carouselinner-authormembers';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_CAROUSELINNER_AUTHORMEMBERS],
        );
    }

    public function getLayoutGrid(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_CAROUSELINNER_AUTHORMEMBERS:
                return array(
                    'row-items' => 12,
                    // Allow ThemeStyle Expansive to change the class
                    'class' => \PoP\Root\App::applyFilters(POP_HOOK_CAROUSEL_USERS_GRIDCLASS, 'col-xs-4 col-sm-2 no-padding'),
                    'divider' => 12
                );
        }

        return parent::getLayoutGrid($componentVariation, $props);
    }

    public function getLayoutSubmodules(array $componentVariation)
    {
        $ret = parent::getLayoutSubmodules($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_CAROUSELINNER_AUTHORMEMBERS:
                $ret[] = [PoP_Module_Processor_CustomPopoverLayouts::class, PoP_Module_Processor_CustomPopoverLayouts::MODULE_LAYOUT_POPOVER_USER_AVATAR];
                break;
        }

        return $ret;
    }
}


