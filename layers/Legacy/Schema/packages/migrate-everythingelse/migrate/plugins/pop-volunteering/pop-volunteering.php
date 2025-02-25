<?php
/*
Plugin Name: PoP Volunteering
Description: Implementation of Volunteering for PoP
Plugin URI: https://getpop.org
Version: 0.1
Author: Leonardo Losovizen/u/leo/
*/

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_VOLUNTEERING_VERSION', 0.132);
define('POP_VOLUNTEERING_DIR', dirname(__FILE__));

class PoP_Volunteering
{
    public function __construct()
    {

        // Priority: after PoP User Platform
        \PoP\Root\App::addAction('plugins_loaded', $this->init(...), 888340);
    }
    public function init()
    {
        define('POP_VOLUNTEERING_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_VOLUNTEERING_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_Volunteering_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_Volunteering_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_Volunteering();
