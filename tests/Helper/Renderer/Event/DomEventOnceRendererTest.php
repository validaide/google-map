<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Renderer\Event;

use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\Event\AbstractEventRenderer;
use Ivory\GoogleMap\Helper\Renderer\Event\DomEventOnceRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DomEventOnceRendererTest extends TestCase
{
    private DomEventOnceRenderer $domEventOnceRenderer;

    protected function setUp(): void
    {
        $this->domEventOnceRenderer = new DomEventOnceRenderer(new Formatter());
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractEventRenderer::class, $this->domEventOnceRenderer);
    }

    public function testRender()
    {
        $event = new Event('instance', 'trigger', 'handle');
        $event->setVariable('event');

        $this->assertSame(
            'event=google.maps.event.addDomListenerOnce(instance,"trigger",handle,false)',
            $this->domEventOnceRenderer->render($event)
        );
    }
}
