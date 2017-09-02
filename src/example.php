<?php 
require_once __DIR__ . '/../vendor/autoload.php';

ini_set('default_socket_timeout', 120);

// Get the file from noaa
$options = array(
    'http' => array(
        'header' => "User-agent: noaa-cap-parser',"
    ),
);

$context = stream_context_create($options);
$xml = file_get_contents('http://alerts.weather.gov/cap/us.php?x=0', false, $context);

// Parse the file
$noaaCapParser = new NoaaCapParser\NoaaCapParser();
$alertArray = $noaaCapParser->parseFromXml($xml);

// Show output
print_r($alertArray);
