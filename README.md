# Distance

[![PHPCS](https://github.com/chiyoyo/distance/actions/workflows/phpcs.yml/badge.svg)](https://github.com/chiyoyo/distance/actions/workflows/phpcs.yml)
[![PHPMD](https://github.com/chiyoyo/distance/actions/workflows/phpmd.yml/badge.svg)](https://github.com/chiyoyo/distance/actions/workflows/phpmd.yml)
[![Test](https://github.com/chiyoyo/distance/actions/workflows/phpunit.yml/badge.svg)](https://github.com/chiyoyo/distance/actions/workflows/phpunit.yml)

## Overview

Calculate the distance between 2 locations.

## Installation

```bash
composer require chiyoyo/distance
```

## Usage

```php
// Coordinate Object
$coordinate1 = new Coordinate($latitude1, $longitude1);
$coordinate2 = new Coordinate($latitude2, $longitude2);

// Hybeny Distance Formula
$distance = Distance::hybeny($coordinate1, $coordinate2);

// Spherical Trigonometry
$distance = Distance::sphericalTrigonometry($coordinate1, $coordinate2);

// Geodesic Sailing
$distance = Distance::geodesicSailing($coordinate1, $coordinate2);
```

## Features

Find the distance (in meters) between two points using the following method.

- Hybeny Distance Formula
- [Spherical Trigonometry](https://en.wikipedia.org/wiki/Spherical_trigonometry)
- Geodesic Sailing

## Author

Kouji Chihara

