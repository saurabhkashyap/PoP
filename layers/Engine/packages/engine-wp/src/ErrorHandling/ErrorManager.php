<?php

declare(strict_types=1);

namespace PoP\EngineWP\ErrorHandling;

use PoP\ComponentModel\ErrorHandling\Error;
use PoP\Engine\ErrorHandling\AbstractErrorManager;
use PoP\Translation\TranslationAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;
use WP_Error;

class ErrorManager extends AbstractErrorManager
{
    protected ?TranslationAPIInterface $translationAPI = null;

    public function setTranslationAPI(TranslationAPIInterface $translationAPI): void
    {
        $this->translationAPI = $translationAPI;
    }
    protected function getTranslationAPI(): TranslationAPIInterface
    {
        return $this->translationAPI ??= $this->getInstanceManager()->getInstance(TranslationAPIInterface::class);
    }

    //#[Required]
    final public function autowireErrorManager(TranslationAPIInterface $translationAPI): void
    {
        $this->translationAPI = $translationAPI;
    }

    public function convertFromCMSToPoPError(object $cmsError): Error
    {
        /** @var WP_Error */
        $cmsError = $cmsError;
        $cmsErrorCodes = $cmsError->get_error_codes();
        if (count($cmsErrorCodes) === 1) {
            $cmsErrorCode = $cmsErrorCodes[0];
            return new Error(
                $cmsErrorCode,
                $cmsError->get_error_message($cmsErrorCode)
            );
        }
        $errorMessages = [];
        foreach ($cmsErrorCodes as $cmsErrorCode) {
            if ($errorMessage = $cmsError->get_error_message($cmsErrorCode)) {
                $errorMessages[] = sprintf(
                    $this->getTranslationAPI()->__('[%s] %s', 'engine-wp'),
                    $cmsErrorCode,
                    $errorMessage
                );
            } else {
                $errorMessages[] = sprintf(
                    $this->getTranslationAPI()->__('Error code: %s', 'engine-wp'),
                    $cmsErrorCode
                );
            }
        }
        return new Error(
            'cms-error',
            sprintf(
                $this->getTranslationAPI()->__('CMS errors: \'%s\'', 'engine-wp'),
                implode($this->getTranslationAPI()->__('\', \'', 'engine-wp'), $errorMessages)
            )
        );
    }

    public function isCMSError(mixed $thing): bool
    {
        return \is_wp_error($thing);
    }
}
