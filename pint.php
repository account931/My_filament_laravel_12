<?php
//pint.json is not working
use Laravel\Pint\Config;

return Config::preset('laravel')
    ->setRules([
        'class_attributes_separation' => false, // disables the rule
    ])
    ->setPaths([
        //'app',
        'routes',
    ])
    ->setExcludes([
        'database',
        'storage',
        'vendor',
    ]);
