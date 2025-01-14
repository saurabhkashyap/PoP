<?php

declare(strict_types=1);

namespace PoP\ComponentModel\ComponentFiltering;

use PoP\ComponentModel\Component\Component;
use PoP\ComponentModel\ComponentFilters\ComponentFilterInterface;

interface ComponentFilterManagerInterface
{
    public function addComponentFilter(ComponentFilterInterface $componentFilter): void;
    public function getSelectedComponentFilterName(): ?string;
    public function setSelectedComponentFilterName(string $selectedComponentFilterName): void;
    public function getNotExcludedComponentSets(): ?array;
    public function setNeverExclude(bool $neverExclude): void;
    public function excludeSubcomponent(Component $component, array &$props): bool;
    /**
     * @param Component[] $subcomponents
     * @return Component[]
     */
    public function removeExcludedSubcomponents(Component $component, array $subcomponents): array;
    /**
     * The `prepare` function advances the componentPath one level down, when interating into the subcomponents, and then calling `restore` the value goes one level up again
     */
    public function prepareForPropagation(Component $component, array &$props): void;
    public function restoreFromPropagation(Component $component, array &$props): void;
}
