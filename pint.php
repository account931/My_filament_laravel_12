<?php

use Laravel\Pint\Config;

file_put_contents('CONFIG_WAS_USED.txt', 'Yes!');

return Config::create()->setPaths([]);
