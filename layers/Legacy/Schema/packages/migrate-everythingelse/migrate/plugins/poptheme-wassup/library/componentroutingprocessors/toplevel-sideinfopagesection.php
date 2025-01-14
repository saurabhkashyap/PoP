<?php

use PoP\ComponentModel\Component\Component;

class PoP_Module_SideInfoPageSectionTopLevelComponentRoutingProcessor extends PoP_Module_SideInfoPageSectionTopLevelComponentRoutingProcessorBase
{
    /**
     * @return array<array<string,mixed>>
     */
    public function getStatePropertiesToSelectComponent(): array
    {
        $ret = array();

        $ret[] = [
        	'component' => [PoP_Module_Processor_PageSections::class, PoP_Module_Processor_PageSections::COMPONENT_PAGESECTION_QUICKVIEWSIDEINFO],
        	'conditions' => [
	            'target' => POP_TARGET_QUICKVIEW,
	        ],
        ];
        $ret[] = [
        	'component' => [PoP_Module_Processor_Offcanvas::class, PoP_Module_Processor_Offcanvas::COMPONENT_OFFCANVAS_BODYSIDEINFO],
        ];

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
		new PoP_Module_SideInfoPageSectionTopLevelComponentRoutingProcessor()
	);
}, 200);
