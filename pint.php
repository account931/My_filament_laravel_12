<?php

// pint.json is not working
use Laravel\Pint\Config;

return Config::preset('laravel')
    ->setRules([
        'class_attributes_separation' => false, // disables the rule
        'ordered_imports' => false, // disables the rule that automatically reorders your use statements.
    ])
    ->setPaths([
        // 'app',
        'routes',
    ])
    ->setExcludes([
        'database',
        'storage',
        'vendor',
    ]);
