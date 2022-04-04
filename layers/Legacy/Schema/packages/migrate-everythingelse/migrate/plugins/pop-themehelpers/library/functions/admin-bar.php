<?php

function hideAdminBarSettings()
{
    ?>
    <style type="text/css">
        .show-admin-bar {
            display: none;
        }
    </style>
    <?php
}
function disableAdminBar()
{
    \PoP\Root\App::addFilter('show_admin_bar', __return_false(...));
    \PoP\Root\App::addAction('admin_print_scripts-profile.php', 'hideAdminBarSettings');
}
\PoP\Root\App::addAction('init', 'disableAdminBar', 9);
