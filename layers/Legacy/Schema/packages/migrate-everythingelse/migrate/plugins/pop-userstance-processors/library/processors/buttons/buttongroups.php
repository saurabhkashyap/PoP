<?php

class PoPVP_Module_Processor_ButtonGroups extends PoP_Module_Processor_CustomButtonGroupsBase
{
    public final const MODULE_BUTTONGROUP_STANCES = 'buttongroup-stances';
    public final const MODULE_BUTTONGROUP_MYSTANCES = 'buttongroup-mystances';
    public final const MODULE_BUTTONGROUP_AUTHORSTANCES = 'buttongroup-authorstances';
    public final const MODULE_BUTTONGROUP_TAGSTANCES = 'buttongroup-tagstances';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BUTTONGROUP_STANCES],
            [self::class, self::MODULE_BUTTONGROUP_MYSTANCES],
            [self::class, self::MODULE_BUTTONGROUP_AUTHORSTANCES],
            [self::class, self::MODULE_BUTTONGROUP_TAGSTANCES],
        );
    }

    protected function getHeadersdataScreen(array $componentVariation, array &$props)
    {
        $screens = array(
            self::MODULE_BUTTONGROUP_STANCES => POP_USERSTANCE_SCREEN_STANCES,
            self::MODULE_BUTTONGROUP_MYSTANCES => POP_USERSTANCE_SCREEN_MYSTANCES,
            self::MODULE_BUTTONGROUP_AUTHORSTANCES => POP_USERSTANCE_SCREEN_AUTHORSTANCES,
            self::MODULE_BUTTONGROUP_TAGSTANCES => POP_USERSTANCE_SCREEN_TAGSTANCES,
        );
        if ($screen = $screens[$componentVariation[1]] ?? null) {
            return $screen;
        }

        return parent::getHeadersdataScreen($componentVariation, $props);
    }

    protected function getHeadersdataFormats(array $componentVariation, array &$props)
    {

        // We can initially have a common format scheme depending on the screen
        $screen = $this->getHeadersdataScreen($componentVariation, $props);
        switch ($screen) {
            case POP_USERSTANCE_SCREEN_STANCES:
            case POP_USERSTANCE_SCREEN_AUTHORSTANCES:
            case POP_USERSTANCE_SCREEN_TAGSTANCES:
            case POP_USERSTANCE_SCREEN_SINGLESTANCES:
                return array(
                    POP_FORMAT_FULLVIEW => array(),
                    POP_FORMAT_LIST => array(
                        POP_FORMAT_LIST,
                        POP_FORMAT_THUMBNAIL,
                    ),
                );

            case POP_USERSTANCE_SCREEN_MYSTANCES:
                return array(
                    POP_FORMAT_TABLE => array(),
                    POP_FORMAT_FULLVIEW => array(),
                );
        }

        return parent::getHeadersdataFormats($componentVariation, $props);
    }
}



