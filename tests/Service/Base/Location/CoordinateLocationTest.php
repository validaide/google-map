<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service\Service\Base\Location;

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Base\Location\CoordinateLocation;
use Ivory\GoogleMap\Service\Base\Location\LocationInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class CoordinateLocationTest extends TestCase
{
    private CoordinateLocation $coordinateLocation;

    private Coordinate|MockObject $coordinate;

    protected function setUp(): void
    {
        $this->coordinate = $this->createCoordinateMock();
        $this->coordinateLocation = new CoordinateLocation($this->coordinate);
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(LocationInterface::class, $this->coordinateLocation);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->coordinate, $this->coordinateLocation->getCoordinate());
    }

    public function testCoordinate()
    {
        $this->coordinateLocation->setCoordinate($coordinate = $this->createCoordinateMock());

        $this->assertSame($coordinate, $this->coordinateLocation->getCoordinate());
    }

    public function testBuildQuery()
    {
        $this->coordinate
            ->expects($this->once())
            ->method('getLatitude')
            ->will($this->returnValue(1.2));

        $this->coordinate
            ->expects($this->once())
            ->method('getLongitude')
            ->will($this->returnValue(2.3));

        $this->assertSame('1.2,2.3', $this->coordinateLocation->buildQuery());
    }

    private function createCoordinateMock(): MockObject|Coordinate
    {
        return $this->createMock(Coordinate::class);
    }
}
