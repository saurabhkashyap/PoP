<?php
class PoP_ServiceWorkers_ResourceLoader_Installation
{
    public function __construct()
    {
        \PoP\Root\App::addAction('PoP:system-generate', $this->systemGenerate(...));
    }

    public function systemGenerate()
    {

        // Modify to load all the resources for the Service Workers
        new PoP_ServiceWorkers_WebPlatform_ResourceLoader_Initialization();
    }
}

/**
 * Initialization
 */
new PoP_ServiceWorkers_ResourceLoader_Installation();
