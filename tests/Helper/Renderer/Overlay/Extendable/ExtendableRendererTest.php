<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Renderer\Overlay\Extendable;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Helper\Renderer\Overlay\Extendable\ExtendableRenderer;
use Ivory\GoogleMap\Helper\Renderer\Overlay\Extendable\ExtendableRendererInterface;
use Ivory\GoogleMap\Overlay\ExtendableInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ExtendableRendererTest extends TestCase
{
    private ExtendableRenderer $extendableRenderer;

    protected function setUp(): void
    {
        $this->extendableRenderer = new ExtendableRenderer();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(ExtendableRendererInterface::class, $this->extendableRenderer);
    }

    public function testSetRenderers()
    {
        $renderers = [$name = 'foo' => $renderer = $this->createExtendableRendererMock()];

        $this->extendableRenderer->setRenderers($renderers);
        $this->extendableRenderer->setRenderers($renderers);

        $this->assertTrue($this->extendableRenderer->hasRenderers());
        $this->assertTrue($this->extendableRenderer->hasRenderer($name));
        $this->assertSame($renderer, $this->extendableRenderer->getRenderer($name));
        $this->assertSame($renderers, $this->extendableRenderer->getRenderers());
    }

    public function testAddRenderers()
    {
        $firstRenderers = ['foo' => $this->createExtendableRendererMock()];
        $secondRenderers = ['bar' => $this->createExtendableRendererMock()];

        $this->extendableRenderer->setRenderers($firstRenderers);
        $this->extendableRenderer->addRenderers($secondRenderers);

        $this->assertTrue($this->extendableRenderer->hasRenderers());
        $this->assertSame([...$firstRenderers, ...$secondRenderers], $this->extendableRenderer->getRenderers());
    }

    public function testSetRenderer()
    {
        $this->extendableRenderer->setRenderer($name = 'foo', $renderer = $this->createExtendableRendererMock());

        $this->assertTrue($this->extendableRenderer->hasRenderers());
        $this->assertTrue($this->extendableRenderer->hasRenderer($name));
        $this->assertSame($renderer, $this->extendableRenderer->getRenderer($name));
        $this->assertSame([$name => $renderer], $this->extendableRenderer->getRenderers());
    }

    public function testRemoveRenderer()
    {
        $this->extendableRenderer->setRenderer($name = 'foo', $this->createExtendableRendererMock());
        $this->extendableRenderer->removeRenderer($name);

        $this->assertFalse($this->extendableRenderer->hasRenderers());
        $this->assertFalse($this->extendableRenderer->hasRenderer($name));
        $this->assertNull($this->extendableRenderer->getRenderer($name));
        $this->assertEmpty($this->extendableRenderer->getRenderers());
    }

    public function testRender()
    {
        $extendableRenderer = $this->createExtendableRendererMock();
        $extendableRenderer
            ->expects($this->once())
            ->method('render')
            ->with(
                $this->identicalTo($extendable = $this->createExtendableMock()),
                $this->identicalTo($bound = $this->createBoundMock())
            )
            ->will($this->returnValue($result = 'result'));

        $this->extendableRenderer->setRenderer($extendable::class, $extendableRenderer);

        $this->assertSame($result, $this->extendableRenderer->render($extendable, $bound));
    }

    public function testRenderWithInvalidExtendable()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/The extendable renderer for ".*" could not be found\./');
        $this->extendableRenderer->render($this->createExtendableMock(), $this->createBoundMock());
    }

    private function createExtendableRendererMock(): MockObject|ExtendableRendererInterface
    {
        return $this->createMock(ExtendableRendererInterface::class);
    }

    private function createExtendableMock(): MockObject|ExtendableInterface
    {
        return $this->createMock(ExtendableInterface::class);
    }

    private function createBoundMock(): MockObject|Bound
    {
        return $this->createMock(Bound::class);
    }
}
