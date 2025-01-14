<?php

class PoP_CommonAutomatedEmails_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::addFilter(
            'PoP_AutomatedEmails_Operator:automatedemail:header',
            $this->getAutomatedemailHeader(...)
        );
        \PoP\Root\App::addFilter(
            'PoP_EmailSender_Utils:init:headers',
            $this->initHeaders(...)
        );
    }

    public function getAutomatedemailHeader($header)
    {
        return 'newsletter';
    }

    public function initHeaders($headers)
    {
        $email = PoP_EmailSender_Utils::getFromEmail();
        if (defined('POP_NEWSLETTER_INITIALIZED')) {
            $email = PoP_Newsletter_EmailUtils::getNewsletterEmail();
        }
        
        $headers['newsletter'] = sprintf(
            "From: %s <%s>\r\n",
            PoP_EmailSender_Utils::getFromName(),
            $email
        ).sprintf(
            "Content-Type: %s; charset=\"%s\"\n",
            PoP_EmailSender_Utils::getContenttype(),
            PoP_EmailSender_Utils::getCharset()
        );
        return $headers;
    }
}

/**
 * Initialization
 */
new PoP_CommonAutomatedEmails_Hooks();
