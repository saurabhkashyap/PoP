<?php

class PoP_WebPlatform_UserLogin_ResourceLoaderProcessor_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'PoP_FrontEnd_ResourceLoaderProcessor:dependencies:manager',
            $this->getManagerDependencies(...)
        );

        \PoP\Root\App::addFilter(
            'PoP_SPAResourceLoader_FileReproduction_InitialResourcesConfig:routes',
            $this->getInitialRoutes(...)
        );
    }

    public function getManagerDependencies($dependencies)
    {

        // User logged-in styles
        $dependencies[] = [PoP_CoreProcessors_DynamicCSSResourceLoaderProcessor::class, PoP_CoreProcessors_DynamicCSSResourceLoaderProcessor::RESOURCE_CSS_USERLOGGEDIN];
        return $dependencies;
    }

    public function getInitialRoutes($routes)
    {
        $routes[] = POP_USERLOGIN_ROUTE_LOGGEDINUSERDATA;
        return $routes;
    }
}

/**
 * Initialization
 */
new PoP_WebPlatform_UserLogin_ResourceLoaderProcessor_Hooks();
