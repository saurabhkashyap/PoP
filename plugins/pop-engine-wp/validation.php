<?php

define('POP_ENGINEWP_POP_ENGINE_MIN_VERSION', 0.1);
define('POP_ENGINEWP_POP_CMSWP_MIN_VERSION', 0.1);

class PoP_EngineWP_Validation
{
    public function validate()
    {
        $success = true;
        if (!defined('POP_ENGINE_VERSION')) {
            add_action('admin_notices', array($this, 'installWarning'));
            add_action('network_admin_notices', array($this, 'installWarning'));
            $success = false;
        } elseif (!defined('POP_ENGINE_INITIALIZED')) {
            add_action('admin_notices', array($this, 'initializeWarning'));
            add_action('network_admin_notices', array($this, 'initializeWarning'));
            $success = false;
        } elseif (POP_ENGINEWP_POP_ENGINE_MIN_VERSION > POP_ENGINE_VERSION) {
            add_action('admin_notices', array($this, 'versionWarning'));
            add_action('network_admin_notices', array($this, 'versionWarning'));
        }

        if (!defined('POP_CMSWP_VERSION')) {
            add_action('admin_notices', array($this, 'install_warning_2'));
            add_action('network_admin_notices', array($this, 'install_warning_2'));
            $success = false;
        } elseif (!defined('POP_CMSWP_INITIALIZED')) {
            add_action('admin_notices', array($this, 'initialize_warning_2'));
            add_action('network_admin_notices', array($this, 'initialize_warning_2'));
            $success = false;
        } elseif (POP_ENGINEWP_POP_CMSWP_MIN_VERSION > POP_CMSWP_VERSION) {
            add_action('admin_notices', array($this, 'version_warning_2'));
            add_action('network_admin_notices', array($this, 'version_warning_2'));
        }

        return $success;
    }
    public function initializeWarning()
    {
        $this->dependencyInitializationWarning(
            __('PoP Engine for WordPress', 'pop-engine-wp'),
            __('PoP Engine', 'pop-engine-wp')
        );
    }
    public function installWarning()
    {
        $this->dependencyInstallationWarning(
            __('PoP Engine for WordPress', 'pop-engine-wp'),
            __('PoP Engine', 'pop-engine-wp'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function versionWarning()
    {
        $this->dependencyVersionWarning(
            __('PoP Engine for WordPress', 'pop-engine-wp'),
            __('PoP Engine', 'pop-engine-wp'),
            'https://github.com/leoloso/PoP',
            POP_ENGINEWP_POP_ENGINE_MIN_VERSION
        );
    }
    public function initialize_warning_2()
    {
        $this->dependencyInitializationWarning(
            __('PoP Engine for WordPress', 'pop-engine-wp'),
            __('PoP WordPress CMS', 'pop-engine-wp')
        );
    }
    public function install_warning_2()
    {
        $this->dependencyInstallationWarning(
            __('PoP Engine for WordPress', 'pop-engine-wp'),
            __('PoP WordPress CMS', 'pop-engine-wp'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function version_warning_2()
    {
        $this->dependencyVersionWarning(
            __('PoP Engine for WordPress', 'pop-engine-wp'),
            __('PoP WordPress CMS', 'pop-engine-wp'),
            'https://github.com/leoloso/PoP',
            POP_ENGINEWP_POP_CMSWP_MIN_VERSION
        );
    }
    protected function dependencyInstallationWarning($plugin, $dependency, $dependency_url)
    {
        $this->adminNotice(
            sprintf(
                __('Error: %s', 'pop-engine-frontend'),
                sprintf(
                    __('<strong>%s</strong> is not installed/activated. Without it, <strong>%s</strong> will not work. Please install this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-engine-frontend'),
                    $dependency,
                    $plugin,
                    $dependency_url
                )
            )
        );
    }
    protected function dependencyInitializationWarning($plugin, $dependency)
    {
        $this->adminNotice(
            sprintf(
                __('Error: %s', 'pop-engine-frontend'),
                sprintf(
                    __('<strong>%s</strong> is not initialized properly. As a consequence, <strong>%s</strong> has not been loaded.', 'pop-engine-frontend'),
                    $dependency,
                    $plugin
                )
            )
        );
    }
    protected function dependencyVersionWarning($plugin, $dependency, $dependency_url, $dependency_min_version)
    {
        $this->adminNotice(
            sprintf(
                __('Error: %s', 'pop-engine-frontend'),
                sprintf(
                    __('<strong>%s</strong> requires version %s or bigger of <strong>%s</strong>. Please update this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-engine-frontend'),
                    $plugin,
                    $dependency_min_version,
                    $dependency,
                    $dependency_url
                )
            )
        );
    }
    protected function adminNotice($message)
    {
        ?>
        <div class="error">
            <p>
        <?php echo $message ?><br/>
                <em>
        <?php _e('Only admins see this message.', 'pop-engine-frontend'); ?>
                </em>
            </p>
        </div>
        <?php
    }
}
