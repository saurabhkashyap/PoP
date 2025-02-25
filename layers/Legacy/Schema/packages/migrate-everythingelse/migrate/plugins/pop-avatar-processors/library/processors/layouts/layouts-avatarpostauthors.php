<?php

class PoP_Module_Processor_PostAuthorAvatarLayouts extends PoP_Module_Processor_PostAuthorAvatarLayoutsBase
{
    public final const COMPONENT_LAYOUTPOST_AUTHORAVATAR = 'layoutpost-authoravatar';
    public final const COMPONENT_LAYOUTPOST_AUTHORAVATAR26 = 'layoutpost-authoravatar26';
    public final const COMPONENT_LAYOUTPOST_AUTHORAVATAR60 = 'layoutpost-authoravatar60';
    public final const COMPONENT_LAYOUTPOST_AUTHORAVATAR82 = 'layoutpost-authoravatar82';
    public final const COMPONENT_LAYOUTPOST_AUTHORAVATAR120 = 'layoutpost-authoravatar120';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUTPOST_AUTHORAVATAR,
            self::COMPONENT_LAYOUTPOST_AUTHORAVATAR26,
            self::COMPONENT_LAYOUTPOST_AUTHORAVATAR60,
            self::COMPONENT_LAYOUTPOST_AUTHORAVATAR82,
            self::COMPONENT_LAYOUTPOST_AUTHORAVATAR120,
        );
    }

    public function getAvatarSize(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component->name) {
            case self::COMPONENT_LAYOUTPOST_AUTHORAVATAR:
                return GD_AVATAR_SIZE_40;

            case self::COMPONENT_LAYOUTPOST_AUTHORAVATAR26:
                return GD_AVATAR_SIZE_26;

            case self::COMPONENT_LAYOUTPOST_AUTHORAVATAR60:
                return GD_AVATAR_SIZE_60;

            case self::COMPONENT_LAYOUTPOST_AUTHORAVATAR82:
                return GD_AVATAR_SIZE_82;

            case self::COMPONENT_LAYOUTPOST_AUTHORAVATAR120:
                return GD_AVATAR_SIZE_120;
        }
        
        return parent::getAvatarSize($component, $props);
    }
}



