<?php
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoPCMSSchema\Comments\TypeResolvers\ObjectType\CommentObjectTypeResolver;

abstract class PoP_Module_Processor_CommentTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerRelationalTypeResolver(\PoP\ComponentModel\Component\Component $component): ?RelationalTypeResolverInterface
    {
        return $this->instanceManager->getInstance(CommentObjectTypeResolver::class);
    }
}
