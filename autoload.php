<?php
define("BASE_PATH", __DIR__);

function __autoload($class)
{
    $parts = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require BASE_PATH . DIRECTORY_SEPARATOR . $parts . '.php';
}
