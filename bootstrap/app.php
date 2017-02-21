<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


// Errors
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('UTC');


// Session
session_start();
session_cache_limiter(false);


// composer autoloader
require __DIR__ . '/../vendor/autoload.php';


/**
 * Debug setup
 */
$whoops = new Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


/**
 * Views/Templates setup
 */
// $templatesPath = __DIR__ . '/../resources/views';
// $compiledTemplatesPath = __DIR__ . '/../resources/cache/views';