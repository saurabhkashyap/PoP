<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/layers/WPSchema/packages/*/src',
        __DIR__ . '/layers/SiteBuilder/packages/*/src',
        __DIR__ . '/layers/Wassup/packages/*/src',
        __DIR__ . '/layers/Legacy/Wassup/packages/*/src',
        __DIR__ . '/layers/Legacy/Schema/packages/*/src',
        __DIR__ . '/layers/Legacy/Engine/packages/*/src',
        __DIR__ . '/layers/Schema/packages/*/src',
        __DIR__ . '/layers/API/packages/*/src',
        __DIR__ . '/layers/GraphQLByPoP/packages/*/src',
        __DIR__ . '/layers/GraphQLAPIForWP/plugins/*/src',
        __DIR__ . '/layers/GraphQLAPIForWP/packages/*/src',
        __DIR__ . '/layers/Engine/packages/*/src',
    ])
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
;