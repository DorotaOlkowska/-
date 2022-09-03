<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

define('APP_DIR', dirname(__DIR__));
define('WEB_DIR', APP_DIR . '/public/');
define('PREVIEW_ENABLED', true);

require_once sprintf('%s/vendor/autoload.php', APP_DIR);
$services = include sprintf('%s/application/configs/services.php', APP_DIR);
$services['router'][1][1] = include sprintf('%s/application/configs/previewRoutes.php', APP_DIR);

$app = new \App\App($services);
$app->__invoke();
$response = $app->getResponse();
$response->send();