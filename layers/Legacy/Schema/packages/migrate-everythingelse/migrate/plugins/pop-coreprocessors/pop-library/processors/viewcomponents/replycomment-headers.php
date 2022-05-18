<?php

class PoP_Module_Processor_ReplyCommentViewComponentHeaders extends PoP_Module_Processor_ReplyCommentViewComponentHeadersBase
{
    public final const MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT = 'viewcomponent-header-replycomment';
    public final const MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT_URL = 'viewcomponent-header-replycomment-url';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT],
            [self::class, self::MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT_URL],
        );
    }

    public function getPostSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT:
                return [PoP_Module_Processor_CommentViewComponentHeaders::class, PoP_Module_Processor_CommentViewComponentHeaders::MODULE_VIEWCOMPONENT_HEADER_COMMENTPOST];
        
            case self::MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT_URL:
                return [PoP_Module_Processor_CommentViewComponentHeaders::class, PoP_Module_Processor_CommentViewComponentHeaders::MODULE_VIEWCOMPONENT_HEADER_COMMENTPOST_URL];
        }
        
        return parent::getPostSubmodule($componentVariation);
    }

    public function getCommentSubmodule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT:
            case self::MODULE_VIEWCOMPONENT_HEADER_REPLYCOMMENT_URL:
                return [PoP_Module_Processor_CommentClippedViewComponentHeaders::class, PoP_Module_Processor_CommentClippedViewComponentHeaders::MODULE_VIEWCOMPONENT_HEADER_COMMENTCLIPPED];
        }
        
        return parent::getCommentSubmodule($componentVariation);
    }
}


