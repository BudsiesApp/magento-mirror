<?php

/**
 * Apply workaround for the libxml PHP bugs:
 * @link https://bugs.php.net/bug.php?id=62577
 * @link https://bugs.php.net/bug.php?id=64938
 */
if (function_exists('libxml_disable_entity_loader')) {
    libxml_disable_entity_loader(false);
}

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BP', dirname(dirname(__FILE__)));

Mage::register('original_include_path', get_include_path());

if (defined('COMPILER_INCLUDE_PATH')) {
    $appPath = COMPILER_INCLUDE_PATH;
    set_include_path($appPath . PS . Mage::registry('original_include_path'));
    include_once COMPILER_INCLUDE_PATH . DS . "Mage_Core_functions.php";
    include_once COMPILER_INCLUDE_PATH . DS . "Varien_Autoload.php";
} else {
    /**
     * Set include path
     */
    $paths = array();
    $paths[] = BP . DS . 'app' . DS . 'code' . DS . 'local';
    $paths[] = BP . DS . 'app' . DS . 'code' . DS . 'community';
    $paths[] = BP . DS . 'app' . DS . 'code' . DS . 'core';
    $paths[] = BP . DS . 'lib';

    $appPath = implode(PS, $paths);
    set_include_path($appPath . PS . Mage::registry('original_include_path'));
    include_once "Mage/Core/functions.php";
    include_once "Varien/Autoload.php";
}

Varien_Autoload::register();

include_once "phpseclib/bootstrap.php";
include_once "mcryptcompat/mcrypt.php";
