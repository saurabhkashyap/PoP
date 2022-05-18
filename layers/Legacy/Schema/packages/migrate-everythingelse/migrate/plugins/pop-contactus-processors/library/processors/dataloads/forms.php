<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPSitesWassup\ContactUsMutations\MutationResolverBridges\ContactUsComponentMutationResolverBridge;

class PoP_ContactUs_Module_Processor_Dataloads extends PoP_Module_Processor_FormDataloadsBase
{
    public final const MODULE_DATALOAD_CONTACTUS = 'dataload-contactus';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_CONTACTUS],
        );
    }

    public function getRelevantRoute(array $componentVariation, array &$props): ?string
    {
        return match($componentVariation[1]) {
            self::MODULE_DATALOAD_CONTACTUS => POP_CONTACTUS_ROUTE_CONTACTUS,
            default => parent::getRelevantRoute($componentVariation, $props),
        };
    }

    public function getRelevantRouteCheckpointTarget(array $componentVariation, array &$props): string
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_CONTACTUS:
                return \PoP\ComponentModel\Constants\DataLoading::ACTION_EXECUTION_CHECKPOINTS;
        }

        return parent::getRelevantRouteCheckpointTarget($componentVariation, $props);
    }

    protected function validateCaptcha(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_CONTACTUS:
                return true;
        }

        return parent::validateCaptcha($componentVariation, $props);
    }

    public function getComponentMutationResolverBridge(array $componentVariation): ?\PoP\ComponentModel\MutationResolverBridges\ComponentMutationResolverBridgeInterface
    {
        $actionexecuters = array(
            self::MODULE_DATALOAD_CONTACTUS => ContactUsComponentMutationResolverBridge::class,
        );
        if ($actionexecuter = $actionexecuters[$componentVariation[1]] ?? null) {
            return $actionexecuter;
        }

        return parent::getComponentMutationResolverBridge($componentVariation);
    }

    protected function getFeedbackmessageModule(array $componentVariation)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_CONTACTUS:
                return [PoP_ContactUs_Module_Processor_FeedbackMessages::class, PoP_ContactUs_Module_Processor_FeedbackMessages::MODULE_FEEDBACKMESSAGE_CONTACTUS];
        }

        return parent::getFeedbackmessageModule($componentVariation);
    }

    protected function getInnerSubmodules(array $componentVariation): array
    {
        $ret = parent::getInnerSubmodules($componentVariation);

        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_CONTACTUS:
                $ret[] = [PoP_ContactUs_Module_Processor_GFForms::class, PoP_ContactUs_Module_Processor_GFForms::MODULE_FORM_CONTACTUS];
                break;
        }

        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_CONTACTUS:
                // Change the 'Loading' message in the Status
                $this->setProp([[PoP_Module_Processor_Status::class, PoP_Module_Processor_Status::MODULE_STATUS]], $props, 'loading-msg', TranslationAPIFacade::getInstance()->__('Sending...', 'pop-genericforms'));
                break;
        }

        parent::initModelProps($componentVariation, $props);
    }
}


