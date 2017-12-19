<?php

// This is global bootstrap for autoloading

use Maslosoft\Sprite\Generator;

define('ASSETS_DIR', realpath(__DIR__ . '/assets'));

echo "Sprite" . (new Generator)->getVersion() . PHP_EOL;
