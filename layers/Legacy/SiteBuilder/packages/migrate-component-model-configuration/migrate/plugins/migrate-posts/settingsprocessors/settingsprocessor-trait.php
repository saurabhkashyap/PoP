<?php
namespace PoPCMSSchema\Posts;

use PoPCMSSchema\Posts\ModuleConfiguration as PostsComponentConfiguration;

trait SettingsProcessor_Trait
{
    public function routesToProcess()
    {
        return array_filter(
            array(
                PostsComponentConfiguration::getPostsRoute(),
            )
        );
    }
}
