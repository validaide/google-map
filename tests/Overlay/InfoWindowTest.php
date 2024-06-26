<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Overlay;

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Base\Size;
use Ivory\GoogleMap\Event\MouseEvent;
use Ivory\GoogleMap\Overlay\ExtendableInterface;
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\InfoWindowType;
use Ivory\GoogleMap\Utility\OptionsAwareInterface;
use Ivory\GoogleMap\Utility\VariableAwareInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class InfoWindowTest extends TestCase
{
    private InfoWindow $infoWindow;

    private ?string $content = null;

    protected function setUp(): void
    {
        $this->infoWindow = new InfoWindow($this->content = '<p>content</p>');
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(ExtendableInterface::class, $this->infoWindow);
        $this->assertInstanceOf(OptionsAwareInterface::class, $this->infoWindow);
        $this->assertInstanceOf(VariableAwareInterface::class, $this->infoWindow);
    }

    public function testDefaultState()
    {
        $this->assertStringStartsWith('infowindow', $this->infoWindow->getVariable());
        $this->assertSame($this->content, $this->infoWindow->getContent());
        $this->assertSame(InfoWindowType::DEFAULT_, $this->infoWindow->getType());
        $this->assertNull($this->infoWindow->getPosition());
        $this->assertFalse($this->infoWindow->hasPixelOffset());
        $this->assertFalse($this->infoWindow->isOpen());
        $this->assertTrue($this->infoWindow->isAutoOpen());
        $this->assertSame(MouseEvent::CLICK, $this->infoWindow->getOpenEvent());
        $this->assertTrue($this->infoWindow->isAutoClose());
        $this->assertFalse($this->infoWindow->hasOptions());
    }

    public function testInitialState()
    {
        $this->infoWindow = new InfoWindow(
            $this->content,
            $type = InfoWindowType::INFO_BOX,
            $position = $this->createCoordinateMock()
        );

        $this->assertSame($type, $this->infoWindow->getType());
        $this->assertSame($position, $this->infoWindow->getPosition());
    }

    public function testContent()
    {
        $this->infoWindow->setContent($content = 'foo');

        $this->assertSame($content, $this->infoWindow->getContent());
    }

    public function testPosition()
    {
        $this->infoWindow->setPosition($position = $this->createCoordinateMock());

        $this->assertSame($position, $this->infoWindow->getPosition());
    }

    public function testResetPosition()
    {
        $this->infoWindow->setPosition($this->createCoordinateMock());
        $this->infoWindow->setPosition(null);

        $this->assertFalse($this->infoWindow->hasPosition());
    }

    public function testPixedOffset()
    {
        $this->infoWindow->setPixelOffset($size = $this->createSizeMock());

        $this->assertSame($size, $this->infoWindow->getPixelOffset());
    }

    public function testResetPixedOffset()
    {
        $this->infoWindow->setPixelOffset($this->createSizeMock());
        $this->infoWindow->setPixelOffset(null);

        $this->assertFalse($this->infoWindow->hasPixelOffset());
    }

    public function testOpen()
    {
        $this->infoWindow->setOpen(true);

        $this->assertTrue($this->infoWindow->isOpen());
    }

    public function testAutoOpen()
    {
        $this->infoWindow->setAutoOpen(false);

        $this->assertFalse($this->infoWindow->isAutoOpen());
    }

    public function testOpenEvent()
    {
        $this->infoWindow->setOpenEvent($openEvent = MouseEvent::MOUSEDOWN);

        $this->assertSame($openEvent, $this->infoWindow->getOpenEvent());
    }

    public function testAutoClose()
    {
        $this->infoWindow->setAutoClose(false);

        $this->assertFalse($this->infoWindow->isAutoClose());
    }

    private function createCoordinateMock(): MockObject|Coordinate
    {
        return $this->createMock(Coordinate::class);
    }

    private function createSizeMock(): MockObject|Size
    {
        return $this->createMock(Size::class);
    }
}
