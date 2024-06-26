<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Collector\Base;

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Helper\Collector\Base\BoundCollector;
use Ivory\GoogleMap\Helper\Collector\Overlay\GroundOverlayCollector;
use Ivory\GoogleMap\Helper\Collector\Overlay\RectangleCollector;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\GroundOverlay;
use Ivory\GoogleMap\Overlay\Rectangle;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class BoundCollectorTest extends TestCase
{
    private BoundCollector $boundCollector;

    protected function setUp(): void
    {
        $this->boundCollector = new BoundCollector(new GroundOverlayCollector(), new RectangleCollector());
    }

    public function testGroundOverlayCollector()
    {
        $groundOverlayCollector = $this->createGroundOverlayCollectorMock();
        $this->boundCollector->setGroundOverlayCollector($groundOverlayCollector);

        $this->assertSame($groundOverlayCollector, $this->boundCollector->getGroundOverlayCollector());
    }

    public function testRectangleCollector()
    {
        $rectangleCollector = $this->createRectangleCollectorMock();
        $this->boundCollector->setRectangleCollector($rectangleCollector);

        $this->assertSame($rectangleCollector, $this->boundCollector->getRectangleCollector());
    }

    public function testCollect()
    {
        $this->assertEmpty($this->boundCollector->collect(new Map()));
    }

    public function testCollectAutoZoom()
    {
        $map = new Map();
        $map->setAutoZoom(true);

        $this->assertSame([$map->getBound()], $this->boundCollector->collect($map));
    }

    public function testCollectGroundOverlay()
    {
        $map = new Map();
        $map->getOverlayManager()->addGroundOverlay(new GroundOverlay('url', $bound = new Bound()));

        $this->assertSame([$bound], $this->boundCollector->collect($map));
    }

    public function testCollectRectangle()
    {
        $map = new Map();
        $map->getOverlayManager()->addRectangle(new Rectangle($bound = new Bound()));

        $this->assertSame([$bound], $this->boundCollector->collect($map));
    }

    private function createGroundOverlayCollectorMock(): MockObject|GroundOverlayCollector
    {
        return $this->createMock(GroundOverlayCollector::class);
    }

    private function createRectangleCollectorMock(): MockObject|RectangleCollector
    {
        return $this->createMock(RectangleCollector::class);
    }
}
