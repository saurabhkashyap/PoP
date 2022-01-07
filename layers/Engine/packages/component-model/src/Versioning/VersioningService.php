<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Versioning;

use PoP\ComponentModel\Facades\Schema\FeedbackMessageStoreFacade;
use PoP\ComponentModel\Feedback\Tokens;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Translation\Facades\TranslationAPIFacade;

class VersioningService implements VersioningServiceInterface
{
    /**
     * Token used to separate the type from the field for setting version constraints
     */
    private const TYPE_FIELD_SEPARATOR = '.';

    private ?array $versionConstraintsForFields = null;
    private ?array $versionConstraintsForDirectives = null;

    /**
     * Initialize the dictionary with the version constraints for specific fields in the schema
     */
    protected function initializeVersionConstraintsForFields(): void
    {
        // Iterate through entries in `fieldVersionConstraints` and set them into a dictionary
        $this->versionConstraintsForFields = [];
        $schemaWarnings = [];
        $translationAPI = TranslationAPIFacade::getInstance();
        $vars = ApplicationState::getVars();
        foreach (($vars['field-version-constraints'] ?? []) as $typeField => $versionConstraint) {
            // All fields are defined as "$type.$fieldName". If not, it's an error
            $entry = explode(self::TYPE_FIELD_SEPARATOR, $typeField);
            if (count($entry) != 2) {
                $schemaWarnings[] = [
                    Tokens::PATH => [$typeField],
                    Tokens::MESSAGE => sprintf(
                        $translationAPI->__(
                            'URL param \'fieldVersionConstraints\' expects the type and field name separated by \'%s\' (eg: \'%s\'), so the following value has been ignored: \'%s\'',
                            'component-model'
                        ),
                        self::TYPE_FIELD_SEPARATOR,
                        '?fieldVersionConstraints[Post.title]=^0.1',
                        $typeField
                    ),
                ];
                continue;
            }
            $maybeNamespacedTypeName = $entry[0];
            $fieldName = $entry[1];
            $this->versionConstraintsForFields[$maybeNamespacedTypeName][$fieldName] = $versionConstraint;
        }
        if ($schemaWarnings) {
            $feedbackMessageStore = FeedbackMessageStoreFacade::getInstance();
            $feedbackMessageStore->addSchemaWarnings($schemaWarnings);
        }
    }

    /**
     * Indicates the version constraints for specific fields in the schema
     */
    public function getVersionConstraintsForField(string $maybeNamespacedTypeName, string $fieldName): ?string
    {
        if ($this->versionConstraintsForFields === null) {
            $this->initializeVersionConstraintsForFields();
        }
        return $this->versionConstraintsForFields[$maybeNamespacedTypeName][$fieldName] ?? null;
    }

    /**
     * Indicates the version constraints for specific directives in the schema
     */
    public function getVersionConstraintsForDirective(string $directiveName): ?string
    {
        if ($this->versionConstraintsForDirectives === null) {
            $vars = ApplicationState::getVars();
            $this->versionConstraintsForDirectives = $vars['directive-version-constraints'];
        }
        return $this->versionConstraintsForDirectives[$directiveName];
    }
}
