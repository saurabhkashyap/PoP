<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\ModuleResolvers;

use Symfony\Contracts\Service\Attribute\Required;
use GraphQLAPI\GraphQLAPI\Constants\ModuleSettingOptions;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\AbstractModuleResolver;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\ModuleResolverTrait;
use GraphQLAPI\GraphQLAPI\ModuleSettings\Properties;
use GraphQLAPI\GraphQLAPI\Plugin;
use GraphQLAPI\GraphQLAPI\PluginEnvironment;
use GraphQLAPI\GraphQLAPI\Registries\CustomPostTypeRegistryInterface;
use GraphQLAPI\GraphQLAPI\Registries\ModuleRegistryInterface;
use GraphQLAPI\GraphQLAPI\Services\CustomPostTypes\CustomPostTypeInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\Translation\TranslationAPIInterface;
use PoPSchema\Comments\TypeResolvers\ObjectType\CommentObjectTypeResolver;
use PoPSchema\CustomPosts\TypeResolvers\UnionType\CustomPostUnionTypeResolver;
use PoPSchema\GenericCustomPosts\TypeResolvers\ObjectType\GenericCustomPostObjectTypeResolver;
use PoPSchema\Media\TypeResolvers\ObjectType\MediaObjectTypeResolver;
use PoPSchema\Menus\TypeResolvers\ObjectType\MenuObjectTypeResolver;
use PoPSchema\Pages\TypeResolvers\ObjectType\PageObjectTypeResolver;
use PoPSchema\PostCategories\TypeResolvers\ObjectType\PostCategoryObjectTypeResolver;
use PoPSchema\Posts\TypeResolvers\ObjectType\PostObjectTypeResolver;
use PoPSchema\PostTags\TypeResolvers\ObjectType\PostTagObjectTypeResolver;
use PoPSchema\SchemaCommons\Constants\Behaviors;
use PoPSchema\UserAvatars\TypeResolvers\ObjectType\UserAvatarObjectTypeResolver;
use PoPSchema\UserRolesWP\TypeResolvers\ObjectType\UserRoleObjectTypeResolver;
use PoPSchema\Users\TypeResolvers\ObjectType\UserObjectTypeResolver;

class SchemaTypeModuleResolver extends AbstractModuleResolver
{
    use ModuleResolverTrait {
        ModuleResolverTrait::hasDocumentation as upstreamHasDocumentation;
    }
    use SchemaTypeModuleResolverTrait;

    public const SCHEMA_ADMIN_FIELDS = Plugin::NAMESPACE . '\schema-admin-fields';
    public const SCHEMA_SELF_FIELDS = Plugin::NAMESPACE . '\schema-self-fields';
    public const SCHEMA_CUSTOMPOSTS = Plugin::NAMESPACE . '\schema-customposts';
    public const SCHEMA_GENERIC_CUSTOMPOSTS = Plugin::NAMESPACE . '\schema-generic-customposts';
    public const SCHEMA_POSTS = Plugin::NAMESPACE . '\schema-posts';
    public const SCHEMA_COMMENTS = Plugin::NAMESPACE . '\schema-comments';
    public const SCHEMA_USERS = Plugin::NAMESPACE . '\schema-users';
    public const SCHEMA_USER_ROLES = Plugin::NAMESPACE . '\schema-user-roles';
    public const SCHEMA_USER_AVATARS = Plugin::NAMESPACE . '\schema-user-avatars';
    public const SCHEMA_PAGES = Plugin::NAMESPACE . '\schema-pages';
    public const SCHEMA_MEDIA = Plugin::NAMESPACE . '\schema-media';
    public const SCHEMA_TAGS = Plugin::NAMESPACE . '\schema-tags';
    public const SCHEMA_POST_TAGS = Plugin::NAMESPACE . '\schema-post-tags';
    public const SCHEMA_CATEGORIES = Plugin::NAMESPACE . '\schema-categories';
    public const SCHEMA_POST_CATEGORIES = Plugin::NAMESPACE . '\schema-post-categories';
    public const SCHEMA_MENUS = Plugin::NAMESPACE . '\schema-menus';
    public const SCHEMA_SETTINGS = Plugin::NAMESPACE . '\schema-settings';

    /**
     * Setting options
     */
    public const OPTION_USE_SINGLE_TYPE_INSTEAD_OF_UNION_TYPE = 'use-single-type-instead-of-union-type';
    public const OPTION_DEFAULT_AVATAR_SIZE = 'default-avatar-size';
    public const OPTION_ROOT_COMMENT_LIST_DEFAULT_LIMIT = 'root-comment-list-default-limit';
    public const OPTION_CUSTOMPOST_COMMENT_OR_COMMENT_RESPONSE_LIST_DEFAULT_LIMIT = 'custompost-comment-list-default-limit';

    /**
     * Hooks
     */
    public const HOOK_GENERIC_CUSTOMPOST_TYPES = __CLASS__ . ':generic-custompost-types';
    public const HOOK_REJECTED_GENERIC_CUSTOMPOST_TYPES = __CLASS__ . ':rejected-generic-custompost-types';
    
    protected ?CommentObjectTypeResolver $commentTypeResolver;
    protected ?CustomPostUnionTypeResolver $customPostUnionTypeResolver;
    protected ?GenericCustomPostObjectTypeResolver $genericCustomPostTypeResolver;
    protected ?MediaObjectTypeResolver $mediaTypeResolver;
    protected ?PageObjectTypeResolver $pageTypeResolver;
    protected ?PostTagObjectTypeResolver $postTagTypeResolver;
    protected ?PostCategoryObjectTypeResolver $postCategoryTypeResolver;
    protected ?MenuObjectTypeResolver $menuTypeResolver;
    protected ?PostObjectTypeResolver $postTypeResolver;
    protected ?UserRoleObjectTypeResolver $userRoleTypeResolver;
    protected ?UserAvatarObjectTypeResolver $userAvatarTypeResolver;
    protected ?UserObjectTypeResolver $userTypeResolver;
    protected ?CustomPostTypeRegistryInterface $customPostTypeRegistry;

    /**
     * Make all properties nullable, becase the ModuleRegistry is registered
     * in the SystemContainer, where there are no typeResolvers so it will be null,
     * and in the ApplicationContainer, from where the "Modules" page is resolved
     * and which does have all the typeResolvers.
     * Function `getDescription` will only be accessed from the Application Container,
     * so the properties will not be null in that situation.
     */
    #[Required]
    public function autowireSchemaTypeModuleResolver(
        ?CommentObjectTypeResolver $commentTypeResolver,
        ?CustomPostUnionTypeResolver $customPostUnionTypeResolver,
        ?GenericCustomPostObjectTypeResolver $genericCustomPostTypeResolver,
        ?MediaObjectTypeResolver $mediaTypeResolver,
        ?PageObjectTypeResolver $pageTypeResolver,
        ?PostTagObjectTypeResolver $postTagTypeResolver,
        ?PostCategoryObjectTypeResolver $postCategoryTypeResolver,
        ?MenuObjectTypeResolver $menuTypeResolver,
        ?PostObjectTypeResolver $postTypeResolver,
        ?UserRoleObjectTypeResolver $userRoleTypeResolver,
        ?UserAvatarObjectTypeResolver $userAvatarTypeResolver,
        ?UserObjectTypeResolver $userTypeResolver,
        ?CustomPostTypeRegistryInterface $customPostTypeRegistry
    ) {
        $this->commentTypeResolver = $commentTypeResolver;
        $this->customPostUnionTypeResolver = $customPostUnionTypeResolver;
        $this->genericCustomPostTypeResolver = $genericCustomPostTypeResolver;
        $this->mediaTypeResolver = $mediaTypeResolver;
        $this->pageTypeResolver = $pageTypeResolver;
        $this->postTagTypeResolver = $postTagTypeResolver;
        $this->postCategoryTypeResolver = $postCategoryTypeResolver;
        $this->menuTypeResolver = $menuTypeResolver;
        $this->postTypeResolver = $postTypeResolver;
        $this->userRoleTypeResolver = $userRoleTypeResolver;
        $this->userAvatarTypeResolver = $userAvatarTypeResolver;
        $this->userTypeResolver = $userTypeResolver;
        $this->customPostTypeRegistry = $customPostTypeRegistry;
    }

    /**
     * @return string[]
     */
    public function getModulesToResolve(): array
    {
        return [
            self::SCHEMA_ADMIN_FIELDS,
            self::SCHEMA_SELF_FIELDS,
            self::SCHEMA_CUSTOMPOSTS,
            self::SCHEMA_GENERIC_CUSTOMPOSTS,
            self::SCHEMA_POSTS,
            self::SCHEMA_PAGES,
            self::SCHEMA_USERS,
            self::SCHEMA_USER_ROLES,
            self::SCHEMA_USER_AVATARS,
            self::SCHEMA_COMMENTS,
            self::SCHEMA_TAGS,
            self::SCHEMA_POST_TAGS,
            self::SCHEMA_CATEGORIES,
            self::SCHEMA_POST_CATEGORIES,
            self::SCHEMA_MEDIA,
            self::SCHEMA_MENUS,
            self::SCHEMA_SETTINGS,
        ];
    }

    /**
     * @return array<array> List of entries that must be satisfied, each entry is an array where at least 1 module must be satisfied
     */
    public function getDependedModuleLists(string $module): array
    {
        switch ($module) {
            case self::SCHEMA_USER_ROLES:
            case self::SCHEMA_USER_AVATARS:
                return [
                    [
                        self::SCHEMA_USERS,
                    ],
                ];
            case self::SCHEMA_GENERIC_CUSTOMPOSTS:
            case self::SCHEMA_POSTS:
            case self::SCHEMA_PAGES:
            case self::SCHEMA_COMMENTS:
            case self::SCHEMA_TAGS:
            case self::SCHEMA_CATEGORIES:
                return [
                    [
                        self::SCHEMA_CUSTOMPOSTS,
                    ],
                ];
            case self::SCHEMA_POST_TAGS:
                return [
                    [
                        self::SCHEMA_POSTS,
                    ],
                    [
                        self::SCHEMA_TAGS,
                    ],
                ];
            case self::SCHEMA_POST_CATEGORIES:
                return [
                    [
                        self::SCHEMA_POSTS,
                    ],
                    [
                        self::SCHEMA_CATEGORIES,
                    ],
                ];
        }
        return parent::getDependedModuleLists($module);
    }

    public function getName(string $module): string
    {
        return match ($module) {
            self::SCHEMA_ADMIN_FIELDS => \__('Schema Admin Fields', 'graphql-api'),
            self::SCHEMA_SELF_FIELDS => \__('Schema Self Fields', 'graphql-api'),
            self::SCHEMA_GENERIC_CUSTOMPOSTS => \__('Schema Generic Custom Posts', 'graphql-api'),
            self::SCHEMA_POSTS => \__('Schema Posts', 'graphql-api'),
            self::SCHEMA_COMMENTS => \__('Schema Comments', 'graphql-api'),
            self::SCHEMA_USERS => \__('Schema Users', 'graphql-api'),
            self::SCHEMA_USER_ROLES => \__('Schema User Roles', 'graphql-api'),
            self::SCHEMA_USER_AVATARS => \__('Schema User Avatars', 'graphql-api'),
            self::SCHEMA_PAGES => \__('Schema Pages', 'graphql-api'),
            self::SCHEMA_MEDIA => \__('Schema Media', 'graphql-api'),
            self::SCHEMA_TAGS => \__('Schema Tags', 'graphql-api'),
            self::SCHEMA_POST_TAGS => \__('Schema Post Tags', 'graphql-api'),
            self::SCHEMA_CATEGORIES => \__('Schema Categories', 'graphql-api'),
            self::SCHEMA_POST_CATEGORIES => \__('Schema Post Categories', 'graphql-api'),
            self::SCHEMA_MENUS => \__('Schema Menus', 'graphql-api'),
            self::SCHEMA_SETTINGS => \__('Schema Settings', 'graphql-api'),
            self::SCHEMA_CUSTOMPOSTS => \__('Schema Custom Posts', 'graphql-api'),
            default => $module,
        };
    }

    public function getDescription(string $module): string
    {
        /**
         * Inner properties will not be null. Assign them their type,
         * to avoid PHPStan errors
         */
        /** @var CommentObjectTypeResolver */
        $commentTypeResolver = $this->commentTypeResolver;
        /** @var GenericCustomPostObjectTypeResolver */
        $genericCustomPostTypeResolver = $this->genericCustomPostTypeResolver;
        /** @var MediaObjectTypeResolver */
        $mediaTypeResolver = $this->mediaTypeResolver;
        /** @var PageObjectTypeResolver */
        $pageTypeResolver = $this->pageTypeResolver;
        /** @var PostTagObjectTypeResolver */
        $postTagTypeResolver = $this->postTagTypeResolver;
        /** @var PostCategoryObjectTypeResolver */
        $postCategoryTypeResolver = $this->postCategoryTypeResolver;
        /** @var MenuObjectTypeResolver */
        $menuTypeResolver = $this->menuTypeResolver;
        /** @var PostObjectTypeResolver */
        $postTypeResolver = $this->postTypeResolver;
        /** @var UserRoleObjectTypeResolver */
        $userRoleTypeResolver = $this->userRoleTypeResolver;
        /** @var UserAvatarObjectTypeResolver */
        $userAvatarTypeResolver = $this->userAvatarTypeResolver;
        /** @var UserObjectTypeResolver */
        $userTypeResolver = $this->userTypeResolver;
        switch ($module) {
            case self::SCHEMA_ADMIN_FIELDS:
                return \__('Add "admin" fields to the schema', 'graphql-api');
            case self::SCHEMA_SELF_FIELDS:
                return \__('Add "self" fields to the schema', 'graphql-api');
            case self::SCHEMA_GENERIC_CUSTOMPOSTS:
                return sprintf(
                    \__('Query any custom post type (added to the schema or not), through a generic type <code>%1$s</code>', 'graphql-api'),
                    $genericCustomPostTypeResolver->getTypeName()
                );
            case self::SCHEMA_POSTS:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('posts', 'graphql-api'),
                    $postTypeResolver->getTypeName()
                );
            case self::SCHEMA_USERS:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('users', 'graphql-api'),
                    $userTypeResolver->getTypeName()
                );
            case self::SCHEMA_USER_ROLES:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('user roles', 'graphql-api'),
                    $userRoleTypeResolver->getTypeName()
                );
            case self::SCHEMA_USER_AVATARS:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('user avatars', 'graphql-api'),
                    $userAvatarTypeResolver->getTypeName()
                );
            case self::SCHEMA_PAGES:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('pages', 'graphql-api'),
                    $pageTypeResolver->getTypeName()
                );
            case self::SCHEMA_MEDIA:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('media elements', 'graphql-api'),
                    $mediaTypeResolver->getTypeName()
                );
            case self::SCHEMA_COMMENTS:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('comments', 'graphql-api'),
                    $commentTypeResolver->getTypeName()
                );
            case self::SCHEMA_POST_TAGS:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('post tags', 'graphql-api'),
                    $postTagTypeResolver->getTypeName()
                );
            case self::SCHEMA_POST_CATEGORIES:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('post categories', 'graphql-api'),
                    $postCategoryTypeResolver->getTypeName()
                );
            case self::SCHEMA_MENUS:
                return sprintf(
                    \__('Query %1$s, through type <code>%2$s</code> added to the schema', 'graphql-api'),
                    \__('menus', 'graphql-api'),
                    $menuTypeResolver->getTypeName()
                );
            case self::SCHEMA_SETTINGS:
                return \__('Fetch settings from the site', 'graphql-api');
            case self::SCHEMA_CUSTOMPOSTS:
                return \__('Base functionality for all custom posts', 'graphql-api');
            case self::SCHEMA_TAGS:
                return \__('Base functionality for all tags', 'graphql-api');
            case self::SCHEMA_CATEGORIES:
        }
        return parent::getDescription($module);
    }

    /**
     * Does the module have HTML Documentation?
     */
    public function hasDocumentation(string $module): bool
    {
        switch ($module) {
            case self::SCHEMA_POSTS:
            case self::SCHEMA_PAGES:
            case self::SCHEMA_USERS:
            case self::SCHEMA_USER_ROLES:
            case self::SCHEMA_USER_AVATARS:
            case self::SCHEMA_COMMENTS:
            case self::SCHEMA_TAGS:
            case self::SCHEMA_POST_TAGS:
            case self::SCHEMA_CATEGORIES:
            case self::SCHEMA_POST_CATEGORIES:
            case self::SCHEMA_MENUS:
            case self::SCHEMA_MEDIA:
                return false;
        }
        return $this->upstreamHasDocumentation($module);
    }

    /**
     * Indicate if the given value is valid for that option
     */
    public function isValidValue(string $module, string $option, mixed $value): bool
    {
        if (
            (
                in_array(
                    $module,
                    [
                        self::SCHEMA_CUSTOMPOSTS,
                        // self::SCHEMA_GENERIC_CUSTOMPOSTS,
                        self::SCHEMA_POSTS,
                        self::SCHEMA_USERS,
                        self::SCHEMA_MEDIA,
                        self::SCHEMA_TAGS,
                        self::SCHEMA_CATEGORIES,
                        self::SCHEMA_PAGES,
                    ]
                ) && in_array(
                    $option,
                    [
                        ModuleSettingOptions::LIST_DEFAULT_LIMIT,
                        ModuleSettingOptions::LIST_MAX_LIMIT,
                    ]
                )
            ) || (
                $module === self::SCHEMA_COMMENTS
                && in_array(
                    $option,
                    [
                        self::OPTION_ROOT_COMMENT_LIST_DEFAULT_LIMIT,
                        self::OPTION_CUSTOMPOST_COMMENT_OR_COMMENT_RESPONSE_LIST_DEFAULT_LIMIT,
                        ModuleSettingOptions::LIST_MAX_LIMIT,
                    ]
                )
            )
        ) {
            // It can't be less than -1, or 0
            if ($value < -1 or $value === 0) {
                return false;
            }
        }
        return parent::isValidValue($module, $option, $value);
    }

    /**
     * Default value for an option set by the module
     */
    public function getSettingsDefaultValue(string $module, string $option): mixed
    {
        // Lower the security constraints for the static app
        $useUnsafe = PluginEnvironment::areUnsafeDefaultsEnabled();
        $defaultValues = [
            self::SCHEMA_ADMIN_FIELDS => [
                ModuleSettingOptions::DEFAULT_VALUE => $useUnsafe,
                ModuleSettingOptions::VALUE_FOR_ADMIN_CLIENTS => true,
            ],
            self::SCHEMA_SELF_FIELDS => [
                ModuleSettingOptions::DEFAULT_VALUE => false,
                ModuleSettingOptions::VALUE_FOR_ADMIN_CLIENTS => false,
            ],
            self::SCHEMA_CUSTOMPOSTS => [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT => 10,
                ModuleSettingOptions::LIST_MAX_LIMIT => $useUnsafe ? -1 : 100,
                self::OPTION_USE_SINGLE_TYPE_INSTEAD_OF_UNION_TYPE => false,
            ],
            self::SCHEMA_GENERIC_CUSTOMPOSTS => [
                ModuleSettingOptions::CUSTOMPOST_TYPES => ['post'],
            ],
            self::SCHEMA_POSTS => [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT => 10,
                ModuleSettingOptions::LIST_MAX_LIMIT => $useUnsafe ? -1 : 100,
                ModuleSettingOptions::ADD_TYPE_TO_CUSTOMPOST_UNION_TYPE => true,
            ],
            self::SCHEMA_PAGES => [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT => 10,
                ModuleSettingOptions::LIST_MAX_LIMIT => $useUnsafe ? -1 : 100,
                ModuleSettingOptions::ADD_TYPE_TO_CUSTOMPOST_UNION_TYPE => false,
            ],
            self::SCHEMA_USERS => [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT => 10,
                ModuleSettingOptions::LIST_MAX_LIMIT => $useUnsafe ? -1 : 100,
            ],
            self::SCHEMA_MEDIA => [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT => 10,
                ModuleSettingOptions::LIST_MAX_LIMIT => $useUnsafe ? -1 : 100,
            ],
            self::SCHEMA_TAGS => [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT => 20,
                ModuleSettingOptions::LIST_MAX_LIMIT => $useUnsafe ? -1 : 200,
            ],
            self::SCHEMA_CATEGORIES => [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT => 20,
                ModuleSettingOptions::LIST_MAX_LIMIT => $useUnsafe ? -1 : 200,
            ],
            self::SCHEMA_SETTINGS => [
                ModuleSettingOptions::ENTRIES => $useUnsafe ? [] : [
                    'siteurl',
                    'home',
                    'blogname',
                    'blogdescription',
                    'WPLANG',
                    'posts_per_page',
                    'comments_per_page',
                    'date_format',
                    'time_format',
                    'blog_charset',
                ],
                ModuleSettingOptions::BEHAVIOR => $useUnsafe ?
                    Behaviors::DENYLIST
                    : Behaviors::ALLOWLIST,
            ],
            self::SCHEMA_USER_AVATARS => [
                self::OPTION_DEFAULT_AVATAR_SIZE => 96,
            ],
            self::SCHEMA_COMMENTS => [
                self::OPTION_ROOT_COMMENT_LIST_DEFAULT_LIMIT => 10,
                self::OPTION_CUSTOMPOST_COMMENT_OR_COMMENT_RESPONSE_LIST_DEFAULT_LIMIT => -1,
                ModuleSettingOptions::LIST_MAX_LIMIT => -1,
            ],
        ];
        return $defaultValues[$module][$option] ?? null;
    }

    /**
     * Array with the inputs to show as settings for the module
     *
     * @return array<array> List of settings for the module, each entry is an array with property => value
     */
    public function getSettings(string $module): array
    {
        /**
         * Inner properties will not be null. Assign them their type,
         * to avoid PHPStan errors
         */
        /** @var CustomPostUnionTypeResolver */
        $customPostUnionTypeResolver = $this->customPostUnionTypeResolver;
        /** @var GenericCustomPostObjectTypeResolver */
        $genericCustomPostTypeResolver = $this->genericCustomPostTypeResolver;
        /** @var PageObjectTypeResolver */
        $pageTypeResolver = $this->pageTypeResolver;
        /** @var PostObjectTypeResolver */
        $postTypeResolver = $this->postTypeResolver;
        /** @var CustomPostTypeRegistryInterface */
        $customPostTypeRegistry = $this->customPostTypeRegistry;
        /** @var UserObjectTypeResolver */
        $userTypeResolver = $this->userTypeResolver;

        $moduleSettings = parent::getSettings($module);
        // Common variables to set the limit on the schema types
        $limitArg = 'limit';
        $unlimitedValue = -1;
        $defaultLimitMessagePlaceholder = \__('Number of results from querying %s when argument <code>%s</code> is not provided. Use <code>%s</code> for unlimited', 'graphql-api');
        $maxLimitMessagePlaceholder = \__('Maximum number of results from querying %s. Use <code>%s</code> for unlimited', 'graphql-api');
        $defaultValueLabel = $this->getDefaultValueLabel();
        $defaultValueDesc = $this->getDefaultValueDescription();
        $adminClientsDesc = $this->getAdminClientDescription();
        // Do the if one by one, so that the SELECT do not get evaluated unless needed
        if ($module == self::SCHEMA_ADMIN_FIELDS) {
            $option = ModuleSettingOptions::DEFAULT_VALUE;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => sprintf(
                    \__('Add admin fields to schema? %s', 'graphql-api'),
                    $defaultValueLabel
                ),
                Properties::DESCRIPTION => sprintf(
                    \__('Add "admin" fields to the GraphQL schema (such as <code>Root.postsForAdmin</code>, <code>Root.roles</code>, and others), which expose private data. %s', 'graphql-api'),
                    $defaultValueDesc
                ),
                Properties::TYPE => Properties::TYPE_BOOL,
            ];
            $option = ModuleSettingOptions::VALUE_FOR_ADMIN_CLIENTS;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Add admin fields for the Admin?', 'graphql-api'),
                Properties::DESCRIPTION => sprintf(
                    \__('Add "admin" fields in the wp-admin? %s', 'graphql-api'),
                    $adminClientsDesc
                ),
                Properties::TYPE => Properties::TYPE_BOOL,
            ];
        } elseif ($module == self::SCHEMA_SELF_FIELDS) {
            $option = ModuleSettingOptions::DEFAULT_VALUE;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => sprintf(
                    \__('Expose the self fields to all types in the schema? %s', 'graphql-api'),
                    $defaultValueLabel
                ),
                Properties::DESCRIPTION => sprintf(
                    \__('The <code>self</code> field returns an instance of the same object, which can be used to adapt the shape of the GraphQL response. %s', 'graphql-api'),
                    $defaultValueDesc
                ),
                Properties::TYPE => Properties::TYPE_BOOL,
            ];
            $option = ModuleSettingOptions::VALUE_FOR_ADMIN_CLIENTS;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Expose self fields for the Admin?', 'graphql-api'),
                Properties::DESCRIPTION => sprintf(
                    \__('Expose self fields in the wp-admin? %s', 'graphql-api'),
                    $adminClientsDesc
                ),
                Properties::TYPE => Properties::TYPE_BOOL,
            ];
        } elseif (
            in_array($module, [
                self::SCHEMA_CUSTOMPOSTS,
                // self::SCHEMA_GENERIC_CUSTOMPOSTS,
                self::SCHEMA_POSTS,
                self::SCHEMA_USERS,
                self::SCHEMA_MEDIA,
                self::SCHEMA_TAGS,
                self::SCHEMA_CATEGORIES,
                self::SCHEMA_PAGES,
            ])
        ) {
            $moduleEntries = [
                self::SCHEMA_CUSTOMPOSTS => [
                    'entities' => \__('custom posts', 'graphql-api'),
                ],
                // self::SCHEMA_GENERIC_CUSTOMPOSTS => [
                //     'genericCustomPosts' => null,
                // ],
                self::SCHEMA_POSTS => [
                    'entities' => \__('posts', 'graphql-api'),
                ],
                self::SCHEMA_USERS => [
                    'entities' => \__('users', 'graphql-api'),
                ],
                self::SCHEMA_MEDIA => [
                    'entities' => \__('media items', 'graphql-api'),
                ],
                self::SCHEMA_TAGS => [
                    'entities' => \__('tags', 'graphql-api'),
                ],
                self::SCHEMA_CATEGORIES => [
                    'entities' => \__('categories', 'graphql-api'),
                ],
                self::SCHEMA_PAGES => [
                    'entities' => \__('pages', 'graphql-api'),
                ],
            ];
            $moduleEntry = $moduleEntries[$module];
            // If the options is not provided, use the default one
            $entities = $moduleEntry['entities'];
            $options = $moduleEntry['options'] ?? [
                ModuleSettingOptions::LIST_DEFAULT_LIMIT,
                ModuleSettingOptions::LIST_MAX_LIMIT,
            ];
            list(
                $defaultLimitOption,
                $maxLimitOption,
            ) = $options;
            $moduleSettings[] = [
                Properties::INPUT => $defaultLimitOption,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $defaultLimitOption
                ),
                Properties::TITLE => sprintf(
                    \__('Default limit for %s', 'graphql-api'),
                    $entities
                ),
                Properties::DESCRIPTION => sprintf(
                    $defaultLimitMessagePlaceholder,
                    $entities,
                    $limitArg,
                    $unlimitedValue
                ),
                Properties::TYPE => Properties::TYPE_INT,
                Properties::MIN_NUMBER => -1,
            ];
            $moduleSettings[] = [
                Properties::INPUT => $maxLimitOption,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $maxLimitOption
                ),
                Properties::TITLE => sprintf(
                    \__('Max limit for %s', 'graphql-api'),
                    $entities
                ),
                Properties::DESCRIPTION => sprintf(
                    $maxLimitMessagePlaceholder,
                    $entities,
                    $unlimitedValue
                ),
                Properties::TYPE => Properties::TYPE_INT,
                Properties::MIN_NUMBER => -1,
            ];

            if ($module == self::SCHEMA_CUSTOMPOSTS) {
                $option = self::OPTION_USE_SINGLE_TYPE_INSTEAD_OF_UNION_TYPE;
                $moduleSettings[] = [
                    Properties::INPUT => $option,
                    Properties::NAME => $this->getSettingOptionName(
                        $module,
                        $option
                    ),
                    Properties::TITLE => \__('Use single type instead of union type?', 'graphql-api'),
                    Properties::DESCRIPTION => sprintf(
                        \__('If type <code>%s</code> is composed of only one type (eg: <code>%s</code>), then return this single type directly in field <code>%s</code>?', 'graphql-api'),
                        $customPostUnionTypeResolver->getTypeName(),
                        $postTypeResolver->getTypeName(),
                        'customPosts'
                    ),
                    Properties::TYPE => Properties::TYPE_BOOL,
                ];
            } elseif (
                in_array($module, [
                    self::SCHEMA_POSTS,
                    self::SCHEMA_PAGES,
                ])
            ) {
                $titlePlaceholder = sprintf(
                    \__('Include type <code>%1$s</code> in <code>%2$s</code>?', 'graphql-api'),
                    '%1$s',
                    $customPostUnionTypeResolver->getTypeName()
                );
                $moduleTitles = [
                    self::SCHEMA_POSTS => sprintf(
                        $titlePlaceholder,
                        $postTypeResolver->getTypeName()
                    ),
                    self::SCHEMA_PAGES => sprintf(
                        $titlePlaceholder,
                        $pageTypeResolver->getTypeName()
                    ),
                ];
                $descriptionPlaceholder = sprintf(
                    \__('Results of type <code>%1$s</code> will be included when querying a field of type <code>%2$s</code> (such as <code>%3$s</code>)', 'graphql-api'),
                    '%1$s',
                    $customPostUnionTypeResolver->getTypeName(),
                    'customPosts'
                );
                $moduleDescriptions = [
                    self::SCHEMA_POSTS => sprintf(
                        $descriptionPlaceholder,
                        $postTypeResolver->getTypeName()
                    ),
                    self::SCHEMA_PAGES => sprintf(
                        $descriptionPlaceholder,
                        $pageTypeResolver->getTypeName()
                    ),
                ];
                $option = ModuleSettingOptions::ADD_TYPE_TO_CUSTOMPOST_UNION_TYPE;
                $moduleSettings[] = [
                    Properties::INPUT => $option,
                    Properties::NAME => $this->getSettingOptionName(
                        $module,
                        $option
                    ),
                    Properties::TITLE => $moduleTitles[$module],
                    Properties::DESCRIPTION => $moduleDescriptions[$module],
                    Properties::TYPE => Properties::TYPE_BOOL,
                ];
            }
        } elseif ($module === self::SCHEMA_COMMENTS) {
            $option = self::OPTION_ROOT_COMMENT_LIST_DEFAULT_LIMIT;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Default limit for querying comments in the Root', 'graphql-api'),
                Properties::DESCRIPTION => sprintf(
                    $defaultLimitMessagePlaceholder,
                    '<code>Root.comments</code>',
                    $limitArg,
                    $unlimitedValue
                ),
                Properties::TYPE => Properties::TYPE_INT,
                Properties::MIN_NUMBER => -1,
            ];

            $option = self::OPTION_CUSTOMPOST_COMMENT_OR_COMMENT_RESPONSE_LIST_DEFAULT_LIMIT;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Default limit for querying comments under a custom post or comment', 'graphql-api'),
                Properties::DESCRIPTION => sprintf(
                    $defaultLimitMessagePlaceholder,
                    sprintf(
                        \__('%s and %s', 'graphql-api'),
                        '<code>CustomPost.comments</code>',
                        '<code>Comment.responses</code>'
                    ),
                    $limitArg,
                    $unlimitedValue
                ),
                Properties::TYPE => Properties::TYPE_INT,
                Properties::MIN_NUMBER => -1,
            ];

            $option = ModuleSettingOptions::LIST_MAX_LIMIT;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Max limit for querying comments', 'graphql-api'),
                Properties::DESCRIPTION => sprintf(
                    $maxLimitMessagePlaceholder,
                    \__('comments', 'graphql-api'),
                    $unlimitedValue
                ),
                Properties::TYPE => Properties::TYPE_INT,
                Properties::MIN_NUMBER => -1,
            ];
        } elseif ($module == self::SCHEMA_GENERIC_CUSTOMPOSTS) {
            // Get the list of custom post types from the system
            $genericCustomPostTypes = \get_post_types();
            /**
             * Not all custom post types make sense or are allowed.
             * Remove the ones that do not
             */
            $pluginCustomPostTypes = array_map(
                fn (CustomPostTypeInterface $customPostTypeService) => $customPostTypeService->getCustomPostType(),
                $customPostTypeRegistry->getCustomPostTypes()
            );
            $rejectedGenericCustomPostTypes = \apply_filters(
                self::HOOK_REJECTED_GENERIC_CUSTOMPOST_TYPES,
                array_merge(
                    // Post Types from GraphQL API are just for configuration
                    // and contain private data
                    $pluginCustomPostTypes,
                    // WordPress internal CPTs
                    // Attachment not allowed because its post_status="inherit",
                    // not "publish", and the API filters by "publish" entries
                    [
                        'attachment',
                        'revision',
                        'nav_menu_item',
                        'custom_css',
                        'customize_changeset',
                        'oembed_cache',
                        'user_request',
                        'wp_block',
                        'wp_area',
                    ]
                )
            );
            $genericCustomPostTypes = array_values(array_diff(
                $genericCustomPostTypes,
                $rejectedGenericCustomPostTypes
            ));
            // Allow plugins to further remove unwanted custom post types
            $genericCustomPostTypes = \apply_filters(
                self::HOOK_GENERIC_CUSTOMPOST_TYPES,
                $genericCustomPostTypes
            );
            // The possible values must have key and value
            $possibleValues = [];
            foreach ($genericCustomPostTypes as $genericCustomPostType) {
                $possibleValues[$genericCustomPostType] = $genericCustomPostType;
            }
            // Set the setting
            $option = ModuleSettingOptions::CUSTOMPOST_TYPES;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Included custom post types', 'graphql-api'),
                Properties::DESCRIPTION => sprintf(
                    \__('Results from these custom post types will be included when querying a field with type <code>%s</code> (such as <code>%s</code>)<br/>Press <code>ctrl</code> or <code>shift</code> keys to select more than one', 'graphql-api'),
                    $genericCustomPostTypeResolver->getTypeName(),
                    'genericCustomPosts'
                ),
                Properties::TYPE => Properties::TYPE_ARRAY,
                // Fetch all Schema Configurations from the DB
                Properties::POSSIBLE_VALUES => $possibleValues,
                Properties::IS_MULTIPLE => true,
            ];
        } elseif (
            in_array($module, [
                self::SCHEMA_SETTINGS,
            ])
        ) {
            $entriesTitle = \__('Settings entries', 'graphql-api');
            $headsUpDesc = sprintf(
                \__('<strong>Heads up:</strong> Entries surrounded with <code>/</code> are evaluated as regex (regular expressions).', 'graphql-api'),
                'option',
            );
            $entryDesc = \__('Eg: Both entries <code>%1$s</code> and <code>/%2$s.*/</code> match option name <code>"%1$s"</code>.', 'graphql-api');
            $moduleDescriptions = [
                self::SCHEMA_SETTINGS => sprintf(
                    \__('%1$s<hr/>%2$s<br/>%3$s', 'graphql-api'),
                    sprintf(
                        \__('List of all the option names, to either allow or deny access to, when querying field <code>%s</code>.', 'graphql-api'),
                        'option'
                    ),
                    $headsUpDesc,
                    sprintf(
                        $entryDesc,
                        'siteurl',
                        'site'
                    )
                ),
            ];
            $option = ModuleSettingOptions::ENTRIES;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => $entriesTitle,
                Properties::DESCRIPTION => $moduleDescriptions[$module],
                Properties::TYPE => Properties::TYPE_ARRAY,
            ];

            $option = ModuleSettingOptions::BEHAVIOR;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Behavior', 'graphql-api'),
                Properties::DESCRIPTION => \__('Are the entries being allowed or denied?<ul><li>👉🏽 Allow access: only the configured entries can be accessed, and no other can.</li><li>👉🏽 Deny access: the configured entries cannot be accessed, all other entries can.</li></ul>', 'graphql-api'),
                Properties::TYPE => Properties::TYPE_STRING,
                Properties::POSSIBLE_VALUES => [
                    Behaviors::ALLOWLIST => \__('Allow access', 'graphql-api'),
                    Behaviors::DENYLIST => \__('Deny access', 'graphql-api'),
                ],
            ];
        } elseif ($module == self::SCHEMA_USER_AVATARS) {
            $option = self::OPTION_DEFAULT_AVATAR_SIZE;
            $moduleSettings[] = [
                Properties::INPUT => $option,
                Properties::NAME => $this->getSettingOptionName(
                    $module,
                    $option
                ),
                Properties::TITLE => \__('Default avatar size', 'graphql-api'),
                Properties::DESCRIPTION => sprintf(
                    \__('Size of the avatar (in pixels) when not providing argument <code>"size"</code> in field <code>%s.avatar</code>', 'graphql-api'),
                    $userTypeResolver->getTypeName()
                ),
                Properties::TYPE => Properties::TYPE_INT,
                Properties::MIN_NUMBER => 1,
            ];
        }

        return $moduleSettings;
    }
}
