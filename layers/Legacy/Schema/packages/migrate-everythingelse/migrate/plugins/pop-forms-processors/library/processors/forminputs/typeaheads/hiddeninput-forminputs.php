<?php

class GD_Processor_SelectableHiddenInputFormInputs extends PoP_Module_Processor_HiddenInputFormInputsBase
{
    public final const MODULE_FORMINPUT_HIDDENINPUT_SELECTABLEREFERENCES = 'forminput-hiddeninput-selectablereferences';
    public final const MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTUSERPROFILES = 'forminput-hiddeninput-selectablelayoutuserrofiles';
    public final const MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTAUTHORS = 'forminput-hiddeninput-selectablelayoutauthors';
    public final const MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTCOAUTHORS = 'forminput-hiddeninput-selectablelayoutcoauthors';
    public final const MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTPROFILES = 'filterinput-hiddeninput-selectablelayoutprofiles';
    public final const MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTCOMMUNITYUSERS = 'filterinput-hiddeninput-selectablelayoutcommunityusers';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLEREFERENCES],
            [self::class, self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTUSERPROFILES],
            [self::class, self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTAUTHORS],
            [self::class, self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTCOAUTHORS],
            [self::class, self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTPROFILES],
            [self::class, self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTCOMMUNITYUSERS],
        );
    }

    public function isMultiple(array $componentVariation): bool
    {
        switch ($componentVariation[1]) {
            case self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLEREFERENCES:
            case self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTUSERPROFILES:
            case self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTAUTHORS:
            case self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTCOAUTHORS:
            case self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTPROFILES:
            case self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTCOMMUNITYUSERS:
                return true;
        }

        return parent::isMultiple($componentVariation);
    }

    public function getName(array $componentVariation): string
    {
        switch ($componentVariation[1]) {
         // case self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLEREFERENCES:
            case self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTPROFILES:
            case self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTCOMMUNITYUSERS:
                $names = array(
                    // self::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLEREFERENCES => POP_INPUTNAME_REFERENCES,
                    self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTPROFILES => 'profiles',
                    self::MODULE_FILTERINPUT_HIDDENINPUT_SELECTABLELAYOUTCOMMUNITYUSERS => 'communityusers',
                );
                return $names[$componentVariation[1]];
        }
        
        return parent::getName($componentVariation);
    }
}

