<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\ComponentModel\ComponentProcessors\FormComponentComponentProcessorInterface;
use PoP\ComponentModel\ComponentProcessors\ComponentProcessorManagerInterface;
use PoPSitesWassup\EverythingElseMutations\MutationResolverUtils\MutationResolverUtils;

trait CreateUpdateProfileMutationResolverBridgeTrait
{
    abstract protected function getComponentProcessorManager(): ComponentProcessorManagerInterface;

    // public function getFormData(): array
    // {
    //     return array_merge(
    //         parent::getFormData(),
    //         $this->getUsercommunitiesFormData()
    //     );
    // }
    protected function getUsercommunitiesFormData()
    {
        $inputs = MutationResolverUtils::getMyCommunityFormInputs();
        /** @var FormComponentComponentProcessorInterface */
        $componentProcessor = $this->getComponentProcessorManager()->getComponentProcessor($inputs['communities']);
        $communities = $componentProcessor->getValue($inputs['communities']);
        return array(
            'communities' => $communities ?? array(),
        );
    }
}
