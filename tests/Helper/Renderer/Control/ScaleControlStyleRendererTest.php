<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Renderer\Control;

use Ivory\GoogleMap\Control\ScaleControlStyle;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractRenderer;
use Ivory\GoogleMap\Helper\Renderer\Control\ScaleControlStyleRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ScaleControlStyleRendererTest extends TestCase
{
    private ScaleControlStyleRenderer $scaleControlStyleRenderer;

    protected function setUp(): void
    {
        $this->scaleControlStyleRenderer = new ScaleControlStyleRenderer(new Formatter());
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractRenderer::class, $this->scaleControlStyleRenderer);
    }

    public function testRender()
    {
        $this->assertSame(
            'google.maps.ScaleControlStyle.DEFAULT',
            $this->scaleControlStyleRenderer->render(ScaleControlStyle::DEFAULT_)
        );
    }
}
