<?php

require_once 'vendor/autoload.php';

$configDirPath = dirname(__FILE__) . '/config';

$GLOBALS['kernel'] = new App\Kernel($configDirPath);

function kernel(): \App\Kernel {
    return $GLOBALS['kernel'];
}