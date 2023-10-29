# Distance

## Overview
Calculate the distance between 2 locations

## Requirement

## Usage

```php
$coordinate1 = new Coordinate($latitude1, $longitude1);
$coordinate2 = new Coordinate($latitude2, $longitude2);
$distance = Distance::hybeny($coordinate1, $coordinate2);
$distance = Distance::sphericalTrigonometry($coordinate1, $coordinate2);
$distance = Distance::geodesicSailing($coordinate1, $coordinate2);
```

## Features

Find the distance (in meters) between two points using the following method.
- 
- 
- 

## Reference

## Author

Kouji Chihara

