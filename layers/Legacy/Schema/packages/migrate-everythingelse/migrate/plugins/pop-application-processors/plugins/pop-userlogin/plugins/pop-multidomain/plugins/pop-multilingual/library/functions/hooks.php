<?php

\PoP\Root\App::addFilter('PoP_ApplicationProcessors_UserLogin_Hooks:backgroundurls:loggedinuser_data', 'popMultidomainQtransMaybeReplacelang', 10, 3);
\PoP\Root\App::addFilter('PoP_ApplicationProcessors_UserLogin_Hooks:backgroundurls:loggedinuser_data', 'popMultidomainMaybeReplacepath', 10, 3);
