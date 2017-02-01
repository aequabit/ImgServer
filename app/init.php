<?php
/**
 * Import the configuration
 */
$config = (require __DIR__ . '/../config.php');

/**
 * Instanciate Slim and pass the configuration into the object
 */
$app = new \Slim\Slim;
$app->config($config['slim']);

/**
 * Setup Eloquent
 */
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($config['eloquent']);
$capsule->bootEloquent();


/**
 * Load the Routes from the routes file
 */
require __DIR__ . '/routes.php';
