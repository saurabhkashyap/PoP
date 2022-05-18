<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class PoP_UserCommunities_Module_Processor_Tables extends PoP_Module_Processor_TablesBase
{
    public final const MODULE_TABLE_MYMEMBERS = 'table-mymembers';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_TABLE_MYMEMBERS],
        );
    }

    public function getInnerSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_TABLE_MYMEMBERS:
                $inners = array(
                    self::MODULE_TABLE_MYMEMBERS => [PoP_UserCommunities_Module_Processor_TableInners::class, PoP_UserCommunities_Module_Processor_TableInners::MODULE_TABLEINNER_MYMEMBERS],
                );

                return $inners[$componentVariation[1]];
        }

        return parent::getInnerSubmodule($componentVariation);
    }

    public function getHeaderTitles(array $componentVariation)
    {
        $ret = parent::getHeaderTitles($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_TABLE_MYMEMBERS:
                $ret[] = TranslationAPIFacade::getInstance()->__('User', 'poptheme-wassup');
                $ret[] = TranslationAPIFacade::getInstance()->__('Status', 'poptheme-wassup');
                $ret[] = TranslationAPIFacade::getInstance()->__('Privileges', 'poptheme-wassup');
                $ret[] = TranslationAPIFacade::getInstance()->__('Tags', 'poptheme-wassup');
                break;
        }
    
        return $ret;
    }
}


