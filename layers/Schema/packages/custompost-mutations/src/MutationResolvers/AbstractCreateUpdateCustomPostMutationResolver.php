<?php

declare(strict_types=1);

namespace PoPSchema\CustomPostMutations\MutationResolvers;

use PoP\ComponentModel\ErrorHandling\Error;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\ComponentModel\State\ApplicationState;
use PoP\LooseContracts\NameResolverInterface;
use PoPSchema\CustomPostMutations\LooseContracts\LooseContractSet;
use PoPSchema\CustomPostMutations\TypeAPIs\CustomPostTypeMutationAPIInterface;
use PoPSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoPSchema\CustomPosts\TypeResolvers\EnumType\CustomPostStatusEnumTypeResolver;
use PoPSchema\CustomPosts\Types\Status;
use PoPSchema\UserRoles\TypeAPIs\UserRoleTypeAPIInterface;
use PoPSchema\UserStateMutations\MutationResolvers\ValidateUserLoggedInMutationResolverTrait;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractCreateUpdateCustomPostMutationResolver extends AbstractMutationResolver implements CustomPostMutationResolverInterface
{
    use ValidateUserLoggedInMutationResolverTrait;

    public const HOOK_EXECUTE_CREATE_OR_UPDATE = __CLASS__ . ':execute-create-or-update';
    public const HOOK_EXECUTE_CREATE = __CLASS__ . ':execute-create';
    public const HOOK_EXECUTE_UPDATE = __CLASS__ . ':execute-update';
    public const HOOK_VALIDATE_CONTENT = __CLASS__ . ':validate-content';

    protected ?CustomPostStatusEnumTypeResolver $customPostStatusEnumTypeResolver = null;
    protected ?NameResolverInterface $nameResolver = null;
    protected ?UserRoleTypeAPIInterface $userRoleTypeAPI = null;
    protected ?CustomPostTypeAPIInterface $customPostTypeAPI = null;
    protected ?CustomPostTypeMutationAPIInterface $customPostTypeMutationAPI = null;

    public function setCustomPostStatusEnumTypeResolver(CustomPostStatusEnumTypeResolver $customPostStatusEnumTypeResolver): void
    {
        $this->customPostStatusEnumTypeResolver = $customPostStatusEnumTypeResolver;
    }
    protected function getCustomPostStatusEnumTypeResolver(): CustomPostStatusEnumTypeResolver
    {
        return $this->customPostStatusEnumTypeResolver ??= $this->instanceManager->getInstance(CustomPostStatusEnumTypeResolver::class);
    }
    public function setNameResolver(NameResolverInterface $nameResolver): void
    {
        $this->nameResolver = $nameResolver;
    }
    protected function getNameResolver(): NameResolverInterface
    {
        return $this->nameResolver ??= $this->instanceManager->getInstance(NameResolverInterface::class);
    }
    public function setUserRoleTypeAPI(UserRoleTypeAPIInterface $userRoleTypeAPI): void
    {
        $this->userRoleTypeAPI = $userRoleTypeAPI;
    }
    protected function getUserRoleTypeAPI(): UserRoleTypeAPIInterface
    {
        return $this->userRoleTypeAPI ??= $this->instanceManager->getInstance(UserRoleTypeAPIInterface::class);
    }
    public function setCustomPostTypeAPI(CustomPostTypeAPIInterface $customPostTypeAPI): void
    {
        $this->customPostTypeAPI = $customPostTypeAPI;
    }
    protected function getCustomPostTypeAPI(): CustomPostTypeAPIInterface
    {
        return $this->customPostTypeAPI ??= $this->instanceManager->getInstance(CustomPostTypeAPIInterface::class);
    }
    public function setCustomPostTypeMutationAPI(CustomPostTypeMutationAPIInterface $customPostTypeMutationAPI): void
    {
        $this->customPostTypeMutationAPI = $customPostTypeMutationAPI;
    }
    protected function getCustomPostTypeMutationAPI(): CustomPostTypeMutationAPIInterface
    {
        return $this->customPostTypeMutationAPI ??= $this->instanceManager->getInstance(CustomPostTypeMutationAPIInterface::class);
    }

    //#[Required]
    final public function autowireAbstractCreateUpdateCustomPostMutationResolver(
        CustomPostStatusEnumTypeResolver $customPostStatusEnumTypeResolver,
        NameResolverInterface $nameResolver,
        UserRoleTypeAPIInterface $userRoleTypeAPI,
        CustomPostTypeAPIInterface $customPostTypeAPI,
        CustomPostTypeMutationAPIInterface $customPostTypeMutationAPI,
    ): void {
        $this->customPostStatusEnumTypeResolver = $customPostStatusEnumTypeResolver;
        $this->nameResolver = $nameResolver;
        $this->userRoleTypeAPI = $userRoleTypeAPI;
        $this->customPostTypeAPI = $customPostTypeAPI;
        $this->customPostTypeMutationAPI = $customPostTypeMutationAPI;
    }

    protected function validateCreateErrors(array $form_data): array
    {
        $errors = [];

        // If there are errors here, don't keep validating others
        $this->validateCreateUpdateErrors($errors, $form_data);
        if ($errors) {
            return $errors;
        }

        // If already exists any of these errors above, return errors
        $this->validateCreate($errors, $form_data);
        if ($errors) {
            return $errors;
        }

        $this->validateContent($errors, $form_data);
        $this->validateCreateContent($errors, $form_data);

        return $errors;
    }

    protected function validateUpdateErrors(array $form_data): array
    {
        $errors = [];

        // If there are errors here, don't keep validating others
        $this->validateCreateUpdateErrors($errors, $form_data);
        if ($errors) {
            return $errors;
        }

        // If already exists any of these errors above, return errors
        $this->validateUpdate($errors, $form_data);
        if ($errors) {
            return $errors;
        }

        $this->validateContent($errors, $form_data);
        $this->validateUpdateContent($errors, $form_data);

        return $errors;
    }

    protected function validateCreateUpdateErrors(array &$errors, array $form_data): void
    {
        // Check that the user is logged-in
        $this->validateUserIsLoggedIn($errors);
        if ($errors) {
            return;
        }


        // Validate user permission
        $vars = ApplicationState::getVars();
        $userID = $vars['global-userstate']['current-user-id'];
        $editCustomPostsCapability = $this->getNameResolver()->getName(LooseContractSet::NAME_EDIT_CUSTOMPOSTS_CAPABILITY);
        if (
            !$this->getUserRoleTypeAPI()->userCan(
                $userID,
                $editCustomPostsCapability
            )
        ) {
            $errors[] = $this->getTranslationAPI()->__('Your user doesn\'t have permission for editing custom posts.', 'custompost-mutations');
            return;
        }

        // Check if the user can publish custom posts
        if (isset($form_data[MutationInputProperties::STATUS]) && $form_data[MutationInputProperties::STATUS] == Status::PUBLISHED) {
            $publishCustomPostsCapability = $this->getNameResolver()->getName(LooseContractSet::NAME_PUBLISH_CUSTOMPOSTS_CAPABILITY);
            if (
                !$this->getUserRoleTypeAPI()->userCan(
                    $userID,
                    $publishCustomPostsCapability
                )
            ) {
                $errors[] = $this->getTranslationAPI()->__('Your user doesn\'t have permission for publishing custom posts.', 'custompost-mutations');
                return;
            }
        }
    }

    protected function getUserNotLoggedInErrorMessage(): string
    {
        return $this->getTranslationAPI()->__('You must be logged in to create or update custom posts', 'custompost-mutations');
    }

    protected function validateContent(array &$errors, array $form_data): void
    {
        // Validate that the status is valid
        if (isset($form_data[MutationInputProperties::STATUS])) {
            $status = $form_data[MutationInputProperties::STATUS];
            if (!in_array($status, $this->getCustomPostStatusEnumTypeResolver()->getEnumValues())) {
                $errors[] = sprintf(
                    $this->getTranslationAPI()->__('Status \'%s\' is not supported', 'custompost-mutations'),
                    $status
                );
            }
        }

        // Allow plugins to add validation for their fields
        $this->getHooksAPI()->doAction(
            self::HOOK_VALIDATE_CONTENT,
            array(&$errors),
            $form_data
        );
    }

    protected function validateCreateContent(array &$errors, array $form_data): void
    {
    }
    protected function validateUpdateContent(array &$errors, array $form_data): void
    {
    }

    protected function validateCreate(array &$errors, array $form_data): void
    {
        // Either the title or the content must be set
        if (
            !isset($form_data[MutationInputProperties::TITLE])
            && !isset($form_data[MutationInputProperties::CONTENT])
        ) {
            $errors[] = $this->getTranslationAPI()->__('Either the title, or the content, must be provided', 'custompost-mutations');
        }
    }

    protected function validateUpdate(array &$errors, array $form_data): void
    {

        $customPostID = $form_data[MutationInputProperties::ID] ?? null;
        if (!$customPostID) {
            $errors[] = $this->getTranslationAPI()->__('The ID is missing', 'custompost-mutations');
            return;
        }

        $post = $this->getCustomPostTypeAPI()->getCustomPost($customPostID);
        if (!$post) {
            $errors[] = sprintf(
                $this->getTranslationAPI()->__('There is no entity with ID \'%s\'', 'custompost-mutations'),
                $customPostID
            );
            return;
        }

        // Check that the user has access to the edited custom post
        $vars = ApplicationState::getVars();
        $userID = $vars['global-userstate']['current-user-id'];
        if (!$this->getCustomPostTypeMutationAPI()->canUserEditCustomPost($userID, $customPostID)) {
            $errors[] = sprintf(
                $this->getTranslationAPI()->__('You don\'t have permission to edit custom post with ID \'%s\'', 'custompost-mutations'),
                $customPostID
            );
            return;
        }
    }

    protected function additionals(int | string $customPostID, array $form_data): void
    {
    }
    protected function updateAdditionals(int | string $customPostID, array $form_data, array $log): void
    {
    }
    protected function createAdditionals(int | string $customPostID, array $form_data): void
    {
    }

    // protected function addCustomPostType(&$post_data)
    // {
    //     $post_data['custompost-type'] = $this->getCustomPostType();
    // }

    protected function addCreateUpdateCustomPostData(array &$post_data, array $form_data): void
    {
        if (isset($form_data[MutationInputProperties::CONTENT])) {
            $post_data['content'] = $form_data[MutationInputProperties::CONTENT];
        }
        if (isset($form_data[MutationInputProperties::TITLE])) {
            $post_data['title'] = $form_data[MutationInputProperties::TITLE];
        }
        if (isset($form_data[MutationInputProperties::STATUS])) {
            $post_data['status'] = $form_data[MutationInputProperties::STATUS];
        }
    }

    protected function getUpdateCustomPostData(array $form_data): array
    {
        $post_data = array(
            'id' => $form_data[MutationInputProperties::ID] ?? null,
        );
        $this->addCreateUpdateCustomPostData($post_data, $form_data);

        return $post_data;
    }

    protected function getCreateCustomPostData(array $form_data): array
    {
        $post_data = [
            'custompost-type' => $this->getCustomPostType(),
        ];
        $this->addCreateUpdateCustomPostData($post_data, $form_data);

        // $this->addCustomPostType($post_data);

        return $post_data;
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function executeUpdateCustomPost(array $data): string | int | null | Error
    {
        return $this->getCustomPostTypeMutationAPI()->updateCustomPost($data);
    }

    protected function createUpdateCustomPost(array $form_data, int | string $customPostID): void
    {
    }

    protected function getUpdateCustomPostDataLog(int | string $customPostID, array $form_data): array
    {
        $log = array(
            'previous-status' => $this->getCustomPostTypeAPI()->getStatus($customPostID),
        );

        return $log;
    }

    /**
     * @return string|int|Error The ID of the updated entity, or an Error
     */
    protected function update(array $form_data): string | int | Error
    {
        $post_data = $this->getUpdateCustomPostData($form_data);
        $customPostID = $post_data['id'];

        // Create the operation log, to see what changed. Needed for
        // - Send email only when post published
        // - Add user notification of post being referenced, only when the reference is new (otherwise it will add the notification each time the user updates the post)
        $log = $this->getUpdateCustomPostDataLog($customPostID, $form_data);

        $result = $this->executeUpdateCustomPost($post_data);

        if (GeneralUtils::isError($result)) {
            return $result;
        } elseif ($result === null) {
            return new Error(
                'update-error',
                $this->getTranslationAPI()->__('Oops, there was a problem... this is embarrassing, huh?', 'custompost-mutations')
            );
        }

        $this->createUpdateCustomPost($form_data, $customPostID);

        // Allow for additional operations (eg: set Action categories)
        $this->additionals($customPostID, $form_data);
        $this->updateAdditionals($customPostID, $form_data, $log);

        // Inject Share profiles here
        $this->getHooksAPI()->doAction(self::HOOK_EXECUTE_CREATE_OR_UPDATE, $customPostID, $form_data);
        $this->getHooksAPI()->doAction(self::HOOK_EXECUTE_UPDATE, $customPostID, $log, $form_data);
        return $customPostID;
    }

    /**
     * @param array<string, mixed> $data
     * @return string|int|null|Error the ID of the created custom post
     */
    protected function executeCreateCustomPost(array $data): string | int | null | Error
    {
        return $this->getCustomPostTypeMutationAPI()->createCustomPost($data);
    }

    /**
     * @return string|int|Error The ID of the created entity, or an Error
     */
    protected function create(array $form_data): string | int | Error
    {
        $post_data = $this->getCreateCustomPostData($form_data);
        $customPostID = $this->executeCreateCustomPost($post_data);

        if (GeneralUtils::isError($customPostID)) {
            return $customPostID;
        } elseif ($customPostID === null) {
            return new Error(
                'create-error',
                $this->getTranslationAPI()->__('Oops, there was a problem... this is embarrassing, huh?', 'custompost-mutations')
            );
        }

        $this->createUpdateCustomPost($form_data, $customPostID);

        // Allow for additional operations (eg: set Action categories)
        $this->additionals($customPostID, $form_data);
        $this->createAdditionals($customPostID, $form_data);

        // Inject Share profiles here
        $this->getHooksAPI()->doAction(self::HOOK_EXECUTE_CREATE_OR_UPDATE, $customPostID, $form_data);
        $this->getHooksAPI()->doAction(self::HOOK_EXECUTE_CREATE, $customPostID, $form_data);

        return $customPostID;
    }
}
