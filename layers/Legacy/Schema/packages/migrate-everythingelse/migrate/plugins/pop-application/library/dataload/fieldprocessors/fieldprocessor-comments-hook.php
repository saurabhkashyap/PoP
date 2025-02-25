<?php
use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\Route\RouteUtils;
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPCMSSchema\Comments\TypeResolvers\ObjectType\CommentObjectTypeResolver;

class PoPGenericForms_DataLoad_ObjectTypeFieldResolver_Comments extends AbstractObjectTypeFieldResolver
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            CommentObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
			'contentClipped',
            'replycommentURL',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): \PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface
    {
        return match($fieldName) {
			'contentClipped' => \PoP\ComponentModel\TypeResolvers\ScalarType\StringScalarTypeResolver::class,
            'replycommentURL' => \PoPSchema\SchemaCommons\TypeResolvers\ScalarType\URLScalarTypeResolver::class,
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'contentClipped' => SchemaTypeModifiers::NON_NULLABLE,
            default => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return match($fieldName) {
			'contentClipped' => $translationAPI->__('', ''),
            'replycommentURL' => $translationAPI->__('', ''),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed> $variables
     * @param array<string, mixed> $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs,
        array $variables,
        array $expressions,
        \PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface $field,
        \PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
        array $options = []
    ): mixed {
        $comment = $object;
        switch ($fieldName) {
            case 'contentClipped':
                $content = $objectTypeResolver->resolveValue($object, 'content', $variables, $expressions, $objectTypeFieldResolutionFeedbackStore, $options);
                if ($objectTypeFieldResolutionFeedbackStore->getErrors() !== []) {
                    return $content;
                }
                return limitString(strip_tags($content), 250);

            case 'replycommentURL':
                $customPostID = $objectTypeResolver->resolveValue($object, 'customPostID', $variables, $expressions, $objectTypeFieldResolutionFeedbackStore, $options);
                if ($objectTypeFieldResolutionFeedbackStore->getErrors() !== []) {
                    return null;
                }
                $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
                $post_name = $componentprocessor_manager->getComponentProcessor([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::COMPONENT_FORMCOMPONENT_CARD_COMMENTPOST])->getName([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::COMPONENT_FORMCOMPONENT_CARD_COMMENTPOST]);
                $comment_name = $componentprocessor_manager->getComponentProcessor([PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::COMPONENT_FORMCOMPONENT_CARD_COMMENT])->getName([PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues::COMPONENT_FORMCOMPONENT_CARD_COMMENT]);
                return GeneralUtils::addQueryArgs([
                    $post_name => $customPostID,
                    $comment_name => $objectTypeResolver->getID($comment),
                ], RouteUtils::getRouteURL(POP_ADDCOMMENTS_ROUTE_ADDCOMMENT));
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $field, $objectTypeFieldResolutionFeedbackStore, $options);
    }
}

// Static Initialization: Attach
(new PoPGenericForms_DataLoad_ObjectTypeFieldResolver_Comments())->attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::OBJECT_TYPE_FIELD_RESOLVERS);
