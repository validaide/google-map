<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Renderer\Overlay;

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractRenderer;
use Ivory\GoogleMap\Helper\Renderer\Overlay\AnimationRenderer;
use Ivory\GoogleMap\Overlay\Animation;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class AnimationRendererTest extends TestCase
{
    private AnimationRenderer $animationRenderer;

    protected function setUp(): void
    {
        $this->animationRenderer = new AnimationRenderer(new Formatter());
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractRenderer::class, $this->animationRenderer);
    }

    public function testRender()
    {
        $this->assertSame('google.maps.Animation.DROP', $this->animationRenderer->render(Animation::DROP));
    }
}
