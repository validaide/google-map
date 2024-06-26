<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Collector\Overlay;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Helper\Collector\Overlay\CircleCollector;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Circle;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class CircleCollectorTest extends TestCase
{
    private CircleCollector $circleCollector;

    protected function setUp(): void
    {
        $this->circleCollector = new CircleCollector();
    }

    public function testCollect()
    {
        $map = new Map();
        $map->getOverlayManager()->addCircle($circle = new Circle(new Coordinate()));

        $this->assertSame([$circle], $this->circleCollector->collect($map));
    }
}
