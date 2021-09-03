<?php

declare(strict_types=1);

namespace PoPSchema\Highlights\TypeResolverPickers;

use PoPSchema\Highlights\Facades\HighlightTypeAPIFacade;
use PoPSchema\Highlights\TypeResolvers\HighlightTypeResolver;
use PoP\ComponentModel\TypeResolverPickers\AbstractTypeResolverPicker;

class AbstractHighlightTypeResolverPicker extends AbstractTypeResolverPicker
{
    public function getObjectTypeResolverClass(): string
    {
        return HighlightTypeResolver::class;
    }

    public function isInstanceOfType(object $object): bool
    {
        $highlightTypeAPI = HighlightTypeAPIFacade::getInstance();
        return $highlightTypeAPI->isInstanceOfHighlightType($object);
    }

    public function isIDOfType(string | int $resultItemID): bool
    {
        $highlightTypeAPI = HighlightTypeAPIFacade::getInstance();
        return $highlightTypeAPI->highlightExists($resultItemID);
    }
}
