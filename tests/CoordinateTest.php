<?php

use Distance\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCoordinate($summary, $latitude, $longitude, $isException): void
    {
        if ($isException) {
            $this->expectException(\Exception::class);
        }

        $coordinate = new Coordinate($latitude, $longitude);

        if (!$isException) {
            $this->assertSame(get_class($coordinate), 'Distance\Coordinate', $summary);
        }
    }

    public static function dataProvider()
    {
        $data = [
            'Latitude Over'        => [100, 0, true],
            'Latitude Over minus'  => [-100, 0, true],
            'Longitude Over'       => [0, 200, true],
            'Longitude Over minus' => [0, -200, false],
            'OK'                   => [0, 0, false],
        ];

        return array_map(function ($key, $item) {
            return array_merge([$key], $item);
        }, array_keys($data), $data);
    }
}
