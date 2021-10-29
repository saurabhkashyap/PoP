<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use Exception;
use PoP\Application\HelperAPIFactory;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\CreateUpdateOrganizationProfileMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class CreateUpdateOrganizationProfileMutationResolverBridge extends CreateUpdateProfileMutationResolverBridge
{
    use CreateUpdateProfileMutationResolverBridgeTrait;
    
    protected ?CreateUpdateOrganizationProfileMutationResolver $createUpdateOrganizationProfileMutationResolver = null;
    
    public function setCreateUpdateOrganizationProfileMutationResolver(CreateUpdateOrganizationProfileMutationResolver $createUpdateOrganizationProfileMutationResolver): void
    {
        $this->createUpdateOrganizationProfileMutationResolver = $createUpdateOrganizationProfileMutationResolver;
    }
    protected function getCreateUpdateOrganizationProfileMutationResolver(): CreateUpdateOrganizationProfileMutationResolver
    {
        return $this->createUpdateOrganizationProfileMutationResolver ??= $this->getInstanceManager()->getInstance(CreateUpdateOrganizationProfileMutationResolver::class);
    }

    //#[Required]
    final public function autowireCreateUpdateOrganizationProfileMutationResolverBridge(
        CreateUpdateOrganizationProfileMutationResolver $createUpdateOrganizationProfileMutationResolver,
    ): void {
        $this->createUpdateOrganizationProfileMutationResolver = $createUpdateOrganizationProfileMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getCreateUpdateOrganizationProfileMutationResolver();
    }

    private function getFormInputs()
    {
        return $this->getCommonuserrolesFormInputs();
    }
    protected function getCommonuserrolesFormInputs()
    {
        $inputs = $this->getHooksAPI()->applyFilters(
            'GD_CreateUpdate_ProfileOrganization_Trait:form-inputs',
            array(
                'organizationtypes' => null,
                'organizationcategories' => null,
                'contact_number' => null,
                'contact_person' => null,
            )
        );

        // If any input is null, throw an exception
        $null_inputs = array_filter($inputs, 'is_null');
        if ($null_inputs) {
            throw new Exception(
                sprintf(
                    'No form inputs defined for: %s',
                    '"' . implode('", "', array_keys($null_inputs)) . '"'
                )
            );
        }

        return $inputs;
    }

    public function getFormData(): array
    {
        return array_merge(
            parent::getFormData(),
            $this->getCommonuserrolesFormData(),
            $this->getUsercommunitiesFormData()
        );
    }
    protected function getCommonuserrolesFormData()
    {
        $cmsapplicationhelpers = HelperAPIFactory::getInstance();
        $inputs = $this->getFormInputs();
        $organizationtypes = $this->getModuleProcessorManager()->getProcessor($inputs['organizationtypes'])->getValue($inputs['organizationtypes']);
        $organizationcategories = $this->getModuleProcessorManager()->getProcessor($inputs['organizationcategories'])->getValue($inputs['organizationcategories']);
        return array(
            'organizationtypes' => $organizationtypes ?? array(),
            'organizationcategories' => $organizationcategories ?? array(),
            'contact_number' => trim($cmsapplicationhelpers->escapeAttributes($this->getModuleProcessorManager()->getProcessor($inputs['contact_number'])->getValue($inputs['contact_number']))),
            'contact_person' => trim($cmsapplicationhelpers->escapeAttributes($this->getModuleProcessorManager()->getProcessor($inputs['contact_person'])->getValue($inputs['contact_person']))),
        );
    }
}
