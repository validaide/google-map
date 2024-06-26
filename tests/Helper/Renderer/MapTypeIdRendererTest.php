<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Renderer;

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\MapTypeIdRenderer;
use Ivory\GoogleMap\MapTypeId;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MapTypeIdRendererTest extends TestCase
{
    private MapTypeIdRenderer $mapTypeIdRenderer;

    protected function setUp(): void
    {
        $this->mapTypeIdRenderer = new MapTypeIdRenderer(new Formatter());
    }

    public function testRender()
    {
        $this->assertSame('google.maps.MapTypeId.HYBRID', $this->mapTypeIdRenderer->render(MapTypeId::HYBRID));
    }
}
