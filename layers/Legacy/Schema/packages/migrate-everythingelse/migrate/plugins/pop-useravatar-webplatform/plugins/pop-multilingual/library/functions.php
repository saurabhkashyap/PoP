<?php

// Add locale to fileupload-userphoto
\PoP\Root\App::addFilter('gd_fileupload-userphoto_locale:filename', 'gdFileuploadUserphotoLocaleFilename');
function gdFileuploadUserphotoLocaleFilename($filename)
{
    $pluginapi = PoP_Multilingual_FunctionsAPIFactory::getInstance();
    return 'locale-'.$pluginapi->getCurrentLanguage().'.js';
}
