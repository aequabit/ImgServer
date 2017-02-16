<?php
/**
 * This is the configuration file.
 */
return [
  'slim' => [
    'baseUrl' => 'https://aqbt.pw'
  ],
  'eloquent' => [
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => '',
    'password' => '',
    'database' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
    'options' => [
        PDO::MYSQL_ATTR_MAX_BUFFER_SIZE => 1024 * 1024 * 64
    ]
  ],
  'settings' => [
    'apikey' => 'something_random',
    'homepage' => 'http://google.de',
    'random' => [
      /**
       * Chars to be used in randomly generated URLs
       */
      'chars' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
      /**
       * Length of randomly generated URLs
       */
      'length' => 8
    ]
  ]
];
