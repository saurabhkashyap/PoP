<?php

declare(strict_types=1);

namespace PoPCMSSchema\Comments\FieldResolvers\ObjectType;

use PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface;
use PoP\ComponentModel\Component\Component;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractQueryableObjectTypeFieldResolver;
use PoP\ComponentModel\FilterInput\FilterInputHelper;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\IntScalarTypeResolver;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use PoP\Root\App;
use PoPCMSSchema\Comments\ComponentProcessors\FormInputs\FilterInputComponentProcessor;
use PoPCMSSchema\Comments\ComponentProcessors\SingleCommentFilterInputContainerComponentProcessor;
use PoPCMSSchema\Comments\Constants\CommentStatus;
use PoPCMSSchema\Comments\Module;
use PoPCMSSchema\Comments\ModuleConfiguration;
use PoPCMSSchema\Comments\TypeAPIs\CommentTypeAPIInterface;
use PoPCMSSchema\Comments\TypeResolvers\InputObjectType\CommentByInputObjectTypeResolver;
use PoPCMSSchema\Comments\TypeResolvers\InputObjectType\CommentSortInputObjectTypeResolver;
use PoPCMSSchema\Comments\TypeResolvers\InputObjectType\RootCommentPaginationInputObjectTypeResolver;
use PoPCMSSchema\Comments\TypeResolvers\InputObjectType\RootCommentsFilterInputObjectTypeResolver;
use PoPCMSSchema\Comments\TypeResolvers\ObjectType\CommentObjectTypeResolver;
use PoPCMSSchema\CustomPosts\TypeHelpers\CustomPostUnionTypeHelpers;
use PoPCMSSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPCMSSchema\SchemaCommons\Resolvers\WithLimitFieldArgResolverTrait;
use PoPSchema\SchemaCommons\Constants\QueryOptions;

class RootObjectTypeFieldResolver extends AbstractQueryableObjectTypeFieldResolver
{
    use WithLimitFieldArgResolverTrait;

    private ?CommentTypeAPIInterface $commentTypeAPI = null;
    private ?IntScalarTypeResolver $intScalarTypeResolver = null;
    private ?CommentObjectTypeResolver $commentObjectTypeResolver = null;
    private ?CommentByInputObjectTypeResolver $commentByInputObjectTypeResolver = null;
    private ?RootCommentsFilterInputObjectTypeResolver $rootCommentsFilterInputObjectTypeResolver = null;
    private ?RootCommentPaginationInputObjectTypeResolver $rootCommentPaginationInputObjectTypeResolver = null;
    private ?CommentSortInputObjectTypeResolver $commentSortInputObjectTypeResolver = null;

    final public function setCommentTypeAPI(CommentTypeAPIInterface $commentTypeAPI): void
    {
        $this->commentTypeAPI = $commentTypeAPI;
    }
    final protected function getCommentTypeAPI(): CommentTypeAPIInterface
    {
        return $this->commentTypeAPI ??= $this->instanceManager->getInstance(CommentTypeAPIInterface::class);
    }
    final public function setIntScalarTypeResolver(IntScalarTypeResolver $intScalarTypeResolver): void
    {
        $this->intScalarTypeResolver = $intScalarTypeResolver;
    }
    final protected function getIntScalarTypeResolver(): IntScalarTypeResolver
    {
        return $this->intScalarTypeResolver ??= $this->instanceManager->getInstance(IntScalarTypeResolver::class);
    }
    final public function setCommentObjectTypeResolver(CommentObjectTypeResolver $commentObjectTypeResolver): void
    {
        $this->commentObjectTypeResolver = $commentObjectTypeResolver;
    }
    final protected function getCommentObjectTypeResolver(): CommentObjectTypeResolver
    {
        return $this->commentObjectTypeResolver ??= $this->instanceManager->getInstance(CommentObjectTypeResolver::class);
    }
    final public function setCommentByInputObjectTypeResolver(CommentByInputObjectTypeResolver $commentByInputObjectTypeResolver): void
    {
        $this->commentByInputObjectTypeResolver = $commentByInputObjectTypeResolver;
    }
    final protected function getCommentByInputObjectTypeResolver(): CommentByInputObjectTypeResolver
    {
        return $this->commentByInputObjectTypeResolver ??= $this->instanceManager->getInstance(CommentByInputObjectTypeResolver::class);
    }
    final public function setRootCommentsFilterInputObjectTypeResolver(RootCommentsFilterInputObjectTypeResolver $rootCommentsFilterInputObjectTypeResolver): void
    {
        $this->rootCommentsFilterInputObjectTypeResolver = $rootCommentsFilterInputObjectTypeResolver;
    }
    final protected function getRootCommentsFilterInputObjectTypeResolver(): RootCommentsFilterInputObjectTypeResolver
    {
        return $this->rootCommentsFilterInputObjectTypeResolver ??= $this->instanceManager->getInstance(RootCommentsFilterInputObjectTypeResolver::class);
    }
    final public function setRootCommentPaginationInputObjectTypeResolver(RootCommentPaginationInputObjectTypeResolver $rootCommentPaginationInputObjectTypeResolver): void
    {
        $this->rootCommentPaginationInputObjectTypeResolver = $rootCommentPaginationInputObjectTypeResolver;
    }
    final protected function getRootCommentPaginationInputObjectTypeResolver(): RootCommentPaginationInputObjectTypeResolver
    {
        return $this->rootCommentPaginationInputObjectTypeResolver ??= $this->instanceManager->getInstance(RootCommentPaginationInputObjectTypeResolver::class);
    }
    final public function setCommentSortInputObjectTypeResolver(CommentSortInputObjectTypeResolver $commentSortInputObjectTypeResolver): void
    {
        $this->commentSortInputObjectTypeResolver = $commentSortInputObjectTypeResolver;
    }
    final protected function getCommentSortInputObjectTypeResolver(): CommentSortInputObjectTypeResolver
    {
        return $this->commentSortInputObjectTypeResolver ??= $this->instanceManager->getInstance(CommentSortInputObjectTypeResolver::class);
    }

    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            RootObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'comment',
            'commentCount',
            'comments',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'commentCount'
                => $this->getIntScalarTypeResolver(),
            'comment',
            'comments'
                => $this->getCommentObjectTypeResolver(),
            default
                => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'commentCount' => SchemaTypeModifiers::NON_NULLABLE,
            'comments' => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'comment' => $this->__('Retrieve a single comment', 'pop-comments'),
            'commentCount' => $this->__('Number of comments on the site', 'pop-comments'),
            'comments' => $this->__('Comments on the site', 'pop-comments'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldFilterInputContainerComponent(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?Component
    {
        return match ($fieldName) {
            'comment' => new Component(SingleCommentFilterInputContainerComponentProcessor::class, SingleCommentFilterInputContainerComponentProcessor::COMPONENT_FILTERINPUTCONTAINER_COMMENT_STATUS),
            default => parent::getFieldFilterInputContainerComponent($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldArgNameTypeResolvers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        $fieldArgNameTypeResolvers = parent::getFieldArgNameTypeResolvers($objectTypeResolver, $fieldName);
        return match ($fieldName) {
            'comment' => array_merge(
                $fieldArgNameTypeResolvers,
                [
                    'by' => $this->getCommentByInputObjectTypeResolver(),
                ]
            ),
            'comments' => array_merge(
                $fieldArgNameTypeResolvers,
                [
                    'filter' => $this->getRootCommentsFilterInputObjectTypeResolver(),
                    'pagination' => $this->getRootCommentPaginationInputObjectTypeResolver(),
                    'sort' => $this->getCommentSortInputObjectTypeResolver(),
                ]
            ),
            'commentCount' => array_merge(
                $fieldArgNameTypeResolvers,
                [
                    'filter' => $this->getRootCommentsFilterInputObjectTypeResolver(),
                ]
            ),
            default => $fieldArgNameTypeResolvers,
        };
    }

    public function getFieldArgTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): int
    {
        return match ([$fieldName => $fieldArgName]) {
            ['comment' => 'by'] => SchemaTypeModifiers::MANDATORY,
            default => parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    public function getAdminFieldArgNames(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        $adminFieldArgNames = parent::getAdminFieldArgNames($objectTypeResolver, $fieldName);
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        switch ($fieldName) {
            case 'comment':
                if ($moduleConfiguration->treatCommentStatusAsAdminData()) {
                    $commentStatusFilterInputName = FilterInputHelper::getFilterInputName(new Component(
                        FilterInputComponentProcessor::class,
                        FilterInputComponentProcessor::COMPONENT_FILTERINPUT_COMMENT_STATUS
                    ));
                    $adminFieldArgNames[] = $commentStatusFilterInputName;
                }
                break;
        }
        return $adminFieldArgNames;
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
        FieldInterface $field,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
        array $options = []
    ): mixed {
        $query = $this->convertFieldArgsToFilteringQueryArgs($objectTypeResolver, $fieldName, $fieldArgs);
        /**
         * If "status" is admin and won't be shown, then default to "approve" only
         */
        if (!array_key_exists('status', $query)) {
            $query['status'] = CommentStatus::APPROVE;
        }
        switch ($fieldName) {
            case 'commentCount':
                return $this->getCommentTypeAPI()->getCommentCount($query);

            case 'comments':
                return $this->getCommentTypeAPI()->getComments($query, [QueryOptions::RETURN_TYPE => ReturnTypes::IDS]);

            case 'comment':
                /**
                 * Only from the mapped CPTs, otherwise we may get an error when
                 * the custom post to which the comment was added, is not accesible
                 * via field `Comment.customPost`:
                 *
                 *   ```
                 *   comments {
                 *     customPost {
                 *       id
                 *     }
                 *   }
                 *   ```
                 */
                $query['custompost-types'] = CustomPostUnionTypeHelpers::getTargetObjectTypeResolverCustomPostTypes();
                if ($comments = $this->getCommentTypeAPI()->getComments($query, [QueryOptions::RETURN_TYPE => ReturnTypes::IDS])) {
                    return $comments[0];
                }
                return null;
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $field, $objectTypeFieldResolutionFeedbackStore, $options);
    }
}
