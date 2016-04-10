<?php 
require_once __DIR__ . '/../vendor/autoload.php';

ini_set('default_socket_timeout', 120);

$example = new Thtroyer\NoaaCapParser\Example();
$example->run();

