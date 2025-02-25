<?php

class PoP_Module_Processor_PreviewNotificationLayouts extends PoP_Module_Processor_PreviewNotificationLayoutsBase
{
    public final const COMPONENT_LAYOUT_PREVIEWNOTIFICATION_DETAILS = 'layout-previewnotification-details';
    public final const COMPONENT_LAYOUT_PREVIEWNOTIFICATION_LIST = 'layout-previewnotification-list';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_LAYOUT_PREVIEWNOTIFICATION_DETAILS,
            self::COMPONENT_LAYOUT_PREVIEWNOTIFICATION_LIST,
        );
    }
    
    public function getUserAvatarComponent(\PoP\ComponentModel\Component\Component $component)
    {
        if (defined('POP_AVATARPROCESSORS_INITIALIZED')) {
            switch ($component->name) {
                case self::COMPONENT_LAYOUT_PREVIEWNOTIFICATION_DETAILS:
                    return [PoP_Module_Processor_PostAuthorAvatarLayouts::class, PoP_Module_Processor_PostAuthorAvatarLayouts::COMPONENT_LAYOUTPOST_AUTHORAVATAR60];
            }
        }

        return parent::getUserAvatarComponent($component);
    }
}


