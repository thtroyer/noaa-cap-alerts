# thtroyer/noaa-cap-alerts

[![Build Status](https://travis-ci.org/thtroyer/noaa-cap-alerts.svg?branch=master)](https://travis-ci.org/thtroyer/noaa-cap-alerts)
[![codecov](https://codecov.io/gh/thtroyer/noaa-cap-alerts/branch/master/graph/badge.svg)](https://codecov.io/gh/thtroyer/noaa-cap-alerts)

## What is this?
This is a PHP 7.1+ library to make it easier to fetch and use weather alerts created by NOAA.

## Setup

Include noaa-cap-alerts into your project:

```
composer require thtroyer/noaa-cap-alerts
composer update
```

Instantiate a new NoaaCapAlerts\NoaaAlerts object.  Calling getAlerts() will download the latest alerts from NOAA, parse and return a set of data objects to be consumed.

```php
$noaaAlerts = new NoaaCapAlerts\NoaaAlerts();
$alerts = $noaaAlerts->getAlerts();

foreach ($alerts as $alert) {
    echo $alert->getTitle();
}
```

See [NoaaCapAlerts\Model\NoaaAlert](https://github.com/thtroyer/noaa-cap-alerts/blob/master/src/NoaaCapAlerts/Model/NoaaAlert.php) class to see what data is currently available.

Features are still being added, so some changes may not be backwards compatible.  Until 1.0, treat new feature versions (0.x) as breaking updates.

More information about NOAA's CAP format is available [here](http://alerts.weather.gov/).

