<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

define('POP_ENGINEWEBPLATFORM_POP_APPLICATION_MIN_VERSION', 0.1);
define('POP_ENGINEWEBPLATFORM_POP_CONFIGURATIONCOMPONENTMODEL_MIN_VERSION', 0.1);
define('POP_ENGINEWEBPLATFORM_POP_ENGINEHTMLCSSPLATFORM_MIN_VERSION', 0.1);
        
class PoPWebPlatform_Validation
{
    public function getProviderValidationClass()
    {
        return \PoP\Root\App::applyFilters(
            'PoP_EngineWebPlatform_Validation:provider-validation-class',
            null
        );
    }

    public function validate()
    {
        $success = true;

        $provider_validation_class = $this->getProviderValidationClass();
        if (is_null($provider_validation_class)) {
            \PoP\Root\App::addAction('admin_notices', $this->providerinstall_warning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->providerinstall_warning(...));
            $success = false;
        } elseif (!(new $provider_validation_class())->validate(false)) {
            \PoP\Root\App::addAction('admin_notices', $this->providerinitialize_warning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->providerinitialize_warning(...));
            $success = false;
        }
        if (!defined('POP_APPLICATION_VERSION')) {
            \PoP\Root\App::addAction('admin_notices', $this->installWarning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->installWarning(...));
            $success = false;
        } elseif (!defined('POP_APPLICATION_INITIALIZED')) {
            \PoP\Root\App::addAction('admin_notices', $this->initializeWarning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->initializeWarning(...));
            $success = false;
        } elseif (POP_ENGINEWEBPLATFORM_POP_APPLICATION_MIN_VERSION > POP_APPLICATION_VERSION) {
            \PoP\Root\App::addAction('admin_notices', $this->versionWarning(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->versionWarning(...));
        }

        if (!defined('POP_CONFIGURATIONCOMPONENTMODEL_VERSION')) {
            \PoP\Root\App::addAction('admin_notices', $this->installWarning_2(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->installWarning_2(...));
            $success = false;
        } elseif (!defined('POP_CONFIGURATIONCOMPONENTMODEL_INITIALIZED')) {
            \PoP\Root\App::addAction('admin_notices', $this->initializeWarning_2(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->initializeWarning_2(...));
            $success = false;
        } elseif (POP_ENGINEWEBPLATFORM_POP_CONFIGURATIONCOMPONENTMODEL_MIN_VERSION > POP_CONFIGURATIONCOMPONENTMODEL_VERSION) {
            \PoP\Root\App::addAction('admin_notices', $this->versionWarning_2(...));
            \PoP\Root\App::addAction('network_admin_notices', $this->versionWarning_2(...));
        }

        // This should go, but it screws initializing the default setting of the platform, so commented until fixing it
        // if (!defined('POP_ENGINEHTMLCSSPLATFORM_VERSION')) {
        //     \PoP\Root\App::addAction('admin_notices', $this->installWarning_3(...));
        //     \PoP\Root\App::addAction('network_admin_notices', $this->installWarning_3(...));
        //     $success = false;
        // } elseif (!defined('POP_ENGINEHTMLCSSPLATFORM_INITIALIZED')) {
        //     \PoP\Root\App::addAction('admin_notices', $this->initializeWarning_3(...));
        //     \PoP\Root\App::addAction('network_admin_notices', $this->initializeWarning_3(...));
        //     $success = false;
        // } elseif (POP_ENGINEWEBPLATFORM_POP_ENGINEHTMLCSSPLATFORM_MIN_VERSION > POP_ENGINEHTMLCSSPLATFORM_VERSION) {
        //     \PoP\Root\App::addAction('admin_notices', $this->versionWarning_3(...));
        //     \PoP\Root\App::addAction('network_admin_notices', $this->versionWarning_3(...));
        // }

        return $success;
    }
    public function providerinstall_warning()
    {
        $this->providerinstall_warning_notice(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform')
        );
    }
    public function providerinitialize_warning()
    {
        $this->providerinitialize_warning_notice(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform')
        );
    }
    public function initializeWarning()
    {
        $this->dependencyInitializationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Application', 'pop-engine-webplatform')
        );
    }
    public function installWarning()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Application', 'pop-engine-webplatform'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function versionWarning()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Application', 'pop-engine-webplatform'),
            'https://github.com/leoloso/PoP',
            POP_ENGINEWEBPLATFORM_POP_APPLICATION_MIN_VERSION
        );
    }
    public function initializeWarning_2()
    {
        $this->dependencyInitializationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Configuration Engine', 'pop-engine-webplatform')
        );
    }
    public function installWarning_2()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Configuration Engine', 'pop-engine-webplatform'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function versionWarning_2()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Configuration Engine', 'pop-engine-webplatform'),
            'https://github.com/leoloso/PoP',
            POP_ENGINEWEBPLATFORM_POP_CONFIGURATIONCOMPONENTMODEL_MIN_VERSION
        );
    }
    public function initializeWarning_3()
    {
        $this->dependencyInitializationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Engine HTML/CSS Platform', 'pop-engine-webplatform')
        );
    }
    public function installWarning_3()
    {
        $this->dependencyInstallationWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Engine HTML/CSS Platform', 'pop-engine-webplatform'),
            'https://github.com/leoloso/PoP'
        );
    }
    public function versionWarning_3()
    {
        $this->dependencyVersionWarning(
            TranslationAPIFacade::getInstance()->__('PoP Engine Web Platform', 'pop-engine-webplatform'),
            TranslationAPIFacade::getInstance()->__('PoP Engine HTML/CSS Platform', 'pop-engine-webplatform'),
            'https://github.com/leoloso/PoP',
            POP_ENGINEWEBPLATFORM_POP_ENGINEHTMLCSSPLATFORM_MIN_VERSION
        );
    }
    protected function providerinstall_warning_notice($plugin)
    {
        $this->adminNotice(
            sprintf(
                TranslationAPIFacade::getInstance()->__('Error: %s', 'pop-engine-webplatform'),
                sprintf(
                    TranslationAPIFacade::getInstance()->__('There is no provider (underlying implementation) for <strong>%s</strong>.', 'pop-engine-webplatform'),
                    $plugin
                )
            )
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
