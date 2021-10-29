<?php

declare(strict_types=1);

namespace PoPSitesWassup\NewsletterMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\FormMutations\MutationResolverBridges\AbstractFormComponentMutationResolverBridge;
use PoPSitesWassup\NewsletterMutations\MutationResolvers\NewsletterSubscriptionMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class NewsletterSubscriptionMutationResolverBridge extends AbstractFormComponentMutationResolverBridge
{
    protected ?NewsletterSubscriptionMutationResolver $newsletterSubscriptionMutationResolver = null;

    public function setNewsletterSubscriptionMutationResolver(NewsletterSubscriptionMutationResolver $newsletterSubscriptionMutationResolver): void
    {
        $this->newsletterSubscriptionMutationResolver = $newsletterSubscriptionMutationResolver;
    }
    protected function getNewsletterSubscriptionMutationResolver(): NewsletterSubscriptionMutationResolver
    {
        return $this->newsletterSubscriptionMutationResolver ??= $this->instanceManager->getInstance(NewsletterSubscriptionMutationResolver::class);
    }

    //#[Required]
    final public function autowireNewsletterSubscriptionMutationResolverBridge(
        NewsletterSubscriptionMutationResolver $newsletterSubscriptionMutationResolver,
    ): void {
        $this->newsletterSubscriptionMutationResolver = $newsletterSubscriptionMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getNewsletterSubscriptionMutationResolver();
    }

    public function getFormData(): array
    {
        $form_data = array(
            'email' => $this->getModuleProcessorManager()->getProcessor([\PoP_Newsletter_Module_Processor_TextFormInputs::class, \PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAIL])->getValue([\PoP_Newsletter_Module_Processor_TextFormInputs::class, \PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAIL]),
            'name' => $this->getModuleProcessorManager()->getProcessor([\PoP_Newsletter_Module_Processor_TextFormInputs::class, \PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTERNAME])->getValue([\PoP_Newsletter_Module_Processor_TextFormInputs::class, \PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTERNAME]),
        );

        return $form_data;
    }
}
