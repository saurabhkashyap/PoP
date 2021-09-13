<?php
use PoPSchema\PostTags\TypeResolvers\ObjectType\PostTagTypeResolver;

class PoP_SocialMediaProviders_DataLoad_FunctionalObjectTypeFieldResolver_TagSocialMediaItems extends PoP_SocialMediaProviders_DataLoad_ObjectTypeFieldResolver_FunctionalSocialMediaItems
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            PostTagTypeResolver::class,
        ];
    }

    protected function getTitleField()
    {
        return 'name';
    }
}

// Static Initialization: Attach
(new PoP_SocialMediaProviders_DataLoad_FunctionalObjectTypeFieldResolver_TagSocialMediaItems())->attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
