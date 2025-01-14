<?php
/*
Plugin Name: PoP No Search Category Posts Web Platform
Description: Implementation of Content Category Posts Web Platform for PoP
Plugin URI: https://getpop.org
Version: 0.1
Author: Leonardo Losovizen/u/leo/
*/

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_NOSEARCHCATEGORYPOSTSWEBPLATFORM_VERSION', 0.132);
define('POP_NOSEARCHCATEGORYPOSTSWEBPLATFORM_DIR', dirname(__FILE__));
define('POP_NOSEARCHCATEGORYPOSTSWEBPLATFORM_PHPTEMPLATES_DIR', POP_NOSEARCHCATEGORYPOSTSWEBPLATFORM_DIR.'/php-templates/compiled');

class PoP_NoSearchCategoryPostsWebPlatform
{
    public function __construct()
    {

        // Priority: after PoP Blog Web Platform
        \PoP\Root\App::addAction('plugins_loaded', $this->init(...), 888520);
    }
    public function init()
    {
        define('POP_NOSEARCHCATEGORYPOSTSWEBPLATFORM_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_NOSEARCHCATEGORYPOSTSWEBPLATFORM_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_NoSearchCategoryPostsWebPlatform_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_NoSearchCategoryPostsWebPlatform_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_NoSearchCategoryPostsWebPlatform();
