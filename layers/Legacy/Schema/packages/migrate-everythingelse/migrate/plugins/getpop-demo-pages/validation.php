<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

define('GETPOPDEMO_POP_APPLICATION_MIN_VERSION', 0.1);

class GetPoPDemo_Pages_Validation
{
    public function validate()
    {
        $success = true;
        if (!defined('POP_APPLICATION_VERSION')) {
            \PoP\Root\App::addAction('admin_notices', $this->installWarning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->installWarning(...));
            $success = false;
        } elseif (!defined('POP_APPLICATION_INITIALIZED')) {
            \PoP\Root\App::addAction('admin_notices', $this->initializeWarning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->initializeWarning(...));
            $success = false;
        } elseif (GETPOPDEMO_POP_APPLICATION_MIN_VERSION > POP_APPLICATION_VERSION) {
            \PoP\Root\App::addAction('admin_notices', $this->versionWarning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->versionWarning(...));
        }

        return $success;
    }
    public function initializeWarning()
    {
        $this->dependencyInitializationWarning(
            TranslationAPIFacade::getInstance()->__('GetPoP Demo Pages', 'getpop-demo-pages'),
            TranslationAPIFacade::getInstance()->__('PoP Application', 'getpop-demo-pages')
        );
    }
    public function installWarning()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('GetPoP Demo Pages', 'getpop-demo-pages'),
            TranslationAPIFacade::getInstance()->__('PoP Application', 'getpop-demo-pages'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function versionWarning()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('GetPoP Demo Pages', 'getpop-demo-pages'),
            TranslationAPIFacade::getInstance()->__('PoP Application', 'getpop-demo-pages'),
            'https://github.com/leoloso/PoP',
            GETPOPDEMO_POP_APPLICATION_MIN_VERSION
        );
    }
    protected function dependencyInstallationWarning($plugin, $dependency, $dependency_url)
    {
        $this->adminNotice(
            sprintf(
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-engine-webplatform'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> is not installed/activated. Without it, <strong>%s</strong> will not work. Please install this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-engine-webplatform'),
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
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-engine-webplatform'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> is not initialized properly. As a consequence, <strong>%s</strong> has not been loaded.', 'pop-engine-webplatform'),
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
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-engine-webplatform'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('<strong>%s</strong> requires version %s or bigger of <strong>%s</strong>. Please update this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.', 'pop-engine-webplatform'),
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
        <?php _e('Only admins see this message.', 'pop-engine-webplatform'); ?>
                </em>
            </p>
        </div>
        <?php
    }
}
