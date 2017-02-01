<?php
/**
 * Load Composer's autoloader
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Require the initialization file to load up the app
 */
require __DIR__ . '/../app/init.php';

/**
 * Run Slim
 */
$app->run();
