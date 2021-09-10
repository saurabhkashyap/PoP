<?php

declare(strict_types=1);

namespace PoP\MandatoryDirectivesByConfiguration\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\Interface\InterfaceTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\Object\ObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\MandatoryDirectivesByConfiguration\ConfigurationEntries\ConfigurableMandatoryDirectivesForFieldsTrait;

trait ConfigurableMandatoryDirectivesForFieldsTypeResolverDecoratorTrait
{
    use ConfigurableMandatoryDirectivesForFieldsTrait;

    public function getRelationalTypeResolverClassesToAttachTo(): array
    {
        return array_map(
            // The tuple has format [typeOrFieldInterfaceResolverClass, fieldName]
            // or [typeOrFieldInterfaceResolverClass, fieldName, $role]
            // or [typeOrFieldInterfaceResolverClass, fieldName, $capability]
            // So, in position [0], will always be the $typeOrFieldInterfaceResolverClass
            fn (array $entry) => $entry[0],
            $this->getConfigurationEntries()
        );
    }

    abstract protected function getMandatoryDirectives(mixed $entryValue = null): array;

    public function getMandatoryDirectivesForFields(ObjectTypeResolverInterface $objectTypeResolver): array
    {
        $mandatoryDirectivesForFields = [];
        $interfaceTypeResolvers = $objectTypeResolver->getAllImplementedInterfaceTypeResolvers();
        // Obtain all capabilities allowed for the current combination of typeResolver/fieldName
        foreach ($this->getFieldNames() as $fieldName) {
            // Calculate all the interfaces that define this fieldName
            $interfaceTypeResolversForField = array_values(array_filter(
                $interfaceTypeResolvers,
                fn (InterfaceTypeResolverInterface $interfaceTypeResolver) => in_array($fieldName, $interfaceTypeResolver->getFieldNamesToImplement()),
            ));
            $interfaceTypeResolverClassesForField = array_map(
                'get_class',
                $interfaceTypeResolversForField
            );
            foreach (
                $this->getEntries(
                    $objectTypeResolver,
                    $interfaceTypeResolverClassesForField,
                    $fieldName
                ) as $entry
            ) {
                $entryValue = $entry[2] ?? null;
                if ($this->removeFieldNameBasedOnMatchingEntryValue($entryValue)) {
                    $mandatoryDirectivesForFields[$fieldName] = $this->getMandatoryDirectives($entryValue);
                }
            }
        }
        return $mandatoryDirectivesForFields;
    }

    protected function removeFieldNameBasedOnMatchingEntryValue($entryValue = null): bool
    {
        return true;
    }
}
