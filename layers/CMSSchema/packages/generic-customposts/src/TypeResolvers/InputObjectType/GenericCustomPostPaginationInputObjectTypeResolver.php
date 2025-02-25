<?php

declare(strict_types=1);

namespace PoPCMSSchema\GenericCustomPosts\TypeResolvers\InputObjectType;

use PoP\Root\App;
use PoPCMSSchema\GenericCustomPosts\Module;
use PoPCMSSchema\GenericCustomPosts\ModuleConfiguration;
use PoPCMSSchema\SchemaCommons\TypeResolvers\InputObjectType\PaginationInputObjectTypeResolver;

class GenericCustomPostPaginationInputObjectTypeResolver extends PaginationInputObjectTypeResolver
{
    public function getTypeName(): string
    {
        return 'GenericCustomPostPaginationInput';
    }

    public function getTypeDescription(): ?string
    {
        return $this->__('Input to paginate generic custom posts', 'customposts');
    }

    protected function getDefaultLimit(): ?int
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        return $moduleConfiguration->getGenericCustomPostListDefaultLimit();
    }

    protected function getMaxLimit(): ?int
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        return $moduleConfiguration->getGenericCustomPostListMaxLimit();
    }
}
