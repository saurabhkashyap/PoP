<?php

\PoP\Root\App::addFilter('gd_useravatar_avatar_sizes', getUseravatarfoundationAvatarSizes(...));
function getUseravatarfoundationAvatarSizes($sizes)
{
    return array_unique(
        array_merge(
            $sizes,
            PoP_AvatarFoundationManagerFactory::getInstance()->getSizes()
        )
    );
}
