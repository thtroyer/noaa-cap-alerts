<?php

use NoaaCapAlerts\NoaaAlerts;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Usage: php -f example/index_example.php
 */

ini_set('default_socket_timeout', 120);

$noaaAlerts = new NoaaAlerts();
print_r($noaaAlerts->getAlerts());
