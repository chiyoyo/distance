<?php

namespace Distance;

/**
 * Coordinate class
 */
class Coordinate
{
    /**
     * Longitude
     *
     * @var float
     */
    private $latitude;

    /**
     * Latitude
     *
     * @var float
     */
    private $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new \Exception('Invalid latitude.');
        }

        if ($longitude < -180 || $longitude > 180) {
            throw new \Exception('Invalid longitude');
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function lat(): float
    {
        return $this->latitude;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function lon(): float
    {
        return $this->longitude;
    }
}
