<?php
use PoP\ComponentModel\State\ApplicationState;
use PoPCMSSchema\Users\TypeResolvers\ObjectType\UserObjectTypeResolver;

abstract class PoP_Module_Processor_UpdateUserDataloadsBase extends PoP_Module_Processor_CreateUpdateUserDataloadsBase
{
    public function getObjectIDOrIDs(\PoP\ComponentModel\Component\Component $component, array &$props, &$data_properties): string | int | array
    {
        return \PoP\Root\App::getState('current-user-id');
    }

    public function getRelationalTypeResolver(\PoP\ComponentModel\Component\Component $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        return $this->instanceManager->getInstance(UserObjectTypeResolver::class);
    }
}
