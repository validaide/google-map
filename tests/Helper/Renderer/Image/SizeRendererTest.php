<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Renderer\Image;

use Ivory\GoogleMap\Helper\Renderer\Image\SizeRenderer;
use Ivory\GoogleMap\Map;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class SizeRendererTest extends TestCase
{
    private SizeRenderer $sizeRenderer;

    protected function setUp(): void
    {
        $this->sizeRenderer = new SizeRenderer();
    }

    public function testRender()
    {
        $this->assertSame(
            '640x640',
            $this->sizeRenderer->render(new Map())
        );
    }

    public function testRenderWithHeight()
    {
        $map = new Map();
        $map->setStaticOption('height', 400);

        $this->assertSame(
            '640x400',
            $this->sizeRenderer->render($map)
        );
    }

    public function testRenderWithWidth()
    {
        $map = new Map();
        $map->setStaticOption('width', 400);

        $this->assertSame(
            '400x640',
            $this->sizeRenderer->render($map)
        );
    }
}
