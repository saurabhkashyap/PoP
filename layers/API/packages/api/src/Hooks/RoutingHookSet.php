<?php

declare(strict_types=1);

namespace PoP\API\Hooks;

use PoP\API\ComponentConfiguration;
use PoP\API\Response\Schemes as APISchemes;
use PoP\ComponentModel\HelperServices\RequestHelperServiceInterface;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Engine\CMS\CMSServiceInterface;
use PoP\Hooks\AbstractHookSet;
use Symfony\Contracts\Service\Attribute\Required;

class RoutingHookSet extends AbstractHookSet
{
    protected ?CMSServiceInterface $cmsService = null;
    protected ?RequestHelperServiceInterface $requestHelperService = null;

    public function setCMSService(CMSServiceInterface $cmsService): void
    {
        $this->cmsService = $cmsService;
    }
    protected function getCMSService(): CMSServiceInterface
    {
        return $this->cmsService ??= $this->instanceManager->getInstance(CMSServiceInterface::class);
    }
    public function setRequestHelperService(RequestHelperServiceInterface $requestHelperService): void
    {
        $this->requestHelperService = $requestHelperService;
    }
    protected function getRequestHelperService(): RequestHelperServiceInterface
    {
        return $this->requestHelperService ??= $this->instanceManager->getInstance(RequestHelperServiceInterface::class);
    }

    //#[Required]
    final public function autowireRoutingHookSet(
        CMSServiceInterface $cmsService,
        RequestHelperServiceInterface $requestHelperService,
    ): void {
        $this->cmsService = $cmsService;
        $this->requestHelperService = $requestHelperService;
    }

    protected function init(): void
    {
        $this->getHooksAPI()->addFilter(
            '\PoP\Routing:uri-route',
            array($this, 'getURIRoute')
        );

        $this->getHooksAPI()->addFilter(
            '\PoP\ComponentModel\Engine:getExtraRoutes',
            array($this, 'getExtraRoutes'),
            10,
            1
        );
    }

    public function getExtraRoutes(array $extraRoutes): array
    {
        // The API cannot use getExtraRoutes()!!!!!
        // Because the fields can't be applied to different resources!
        // (Eg: author/leo/ and author/leo/?route=posts)
        $vars = ApplicationState::getVars();
        if (isset($vars['scheme']) && $vars['scheme'] == APISchemes::API) {
            return [];
        }

        return $extraRoutes;
    }

    /**
     * Replace REQUEST_URI with the website's home URL.
     * Watch out: If the homeURL is not contained in the current URL
     * then there's a misconfiguration in the server
     */
    public function getURIRoute(string $route): string
    {
        if (!ComponentConfiguration::overrideRequestURI()) {
            return $route;
        }
        $homeURL = $this->getCmsService()->getHomeURL();
        $currentURL = $this->getRequestHelperService()->getCurrentURL();
        // Remove the protocol to avoid erroring on http/https
        $homeURL = preg_replace('#^https?://#', '', $homeURL);
        $currentURL = preg_replace('#^https?://#', '', $currentURL);
        if (substr($currentURL, 0, strlen($homeURL)) != $homeURL) {
            // This is too harsh. Just ignore hook
            // throw new Exception(sprintf(
            //     'The webserver is not configured properly, since the current URL \'%s\' does not contain the home URL \'%s\' (possibly the server name has not been set-up correctly)',
            //     $currentURL,
            //     $homeURL
            // ));
            return $route;
        }
        return substr($currentURL, strlen($homeURL));
    }
}
