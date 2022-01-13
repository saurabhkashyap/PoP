<?php
namespace PoPSchema\TaxonomyQuery;

class PoP_Application_TaxonomyQuery_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::getHookManager()->addFilter(
            'useAllcontentCategories',
            array($this, 'useAllcontentCategories')
        );
    }

    public function useAllcontentCategories($use)
    {
        return \PoP_Application_TaxonomyQuery_ConfigurationUtils::enableFilterAllcontentByTaxonomy();
    }
}

/**
 * Initialization
 */
new PoP_Application_TaxonomyQuery_Hooks();
