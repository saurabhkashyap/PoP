<?php
/*
Plugin Name: PoP User Meta for WordPress
Version: 0.1
Description: Implementation of WordPress functions for PoP CMS
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
namespace PoPCMSSchema\UserMeta\WP;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_USERMETAWP_VERSION', 0.106);
define('POP_USERMETAWP_DIR', dirname(__FILE__));

class Plugin
{
    public function __construct()
    {
        include_once 'validation.php';
        \PoP\Root\App::addFilter(
            'PoP_UserMeta_Validation:provider-validation-class',
            array($this, 'getProviderValidationClass')
        );

        // Priority: mid section, after PoP CMS Model WP
        \PoP\Root\App::addAction('plugins_loaded', array($this, 'init'), 888255);
    }
    public function getProviderValidationClass($class)
    {
        return Validation::class;
    }

    public function init()
    {
        if ($this->validate()) {
            $this->initialize();
            define('POP_USERMETAWP_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        // require_once 'validation.php';
        $validation = new Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new Plugin();
