<?php

declare(strict_types = 1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR; 

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('TEMPLATES_PATH', $root . 'templates' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);
define('STATIC_PATH', $root . 'static' . DIRECTORY_SEPARATOR);
require_once APP_PATH . 'app.php';


$templates = getFileLocations('index.html');
$forms = getFormLocations('index.html');
$preview = getFileLocations('Preview.png');
$names = getSiteName();

require_once VIEWS_PATH . 'home.php';

