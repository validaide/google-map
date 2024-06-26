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
use Ivory\GoogleMap\Overlay\ExtendableInterface;
use Ivory\GoogleMap\Overlay\IconSequence;
use Ivory\GoogleMap\Overlay\Polyline;
use Ivory\GoogleMap\Utility\OptionsAwareInterface;
use Ivory\GoogleMap\Utility\StaticOptionsAwareInterface;
use Ivory\GoogleMap\Utility\VariableAwareInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PolylineTest extends TestCase
{
    private Polyline $polyline;

    protected function setUp(): void
    {
        $this->polyline = new Polyline();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(ExtendableInterface::class, $this->polyline);
        $this->assertInstanceOf(OptionsAwareInterface::class, $this->polyline);
        $this->assertInstanceOf(StaticOptionsAwareInterface::class, $this->polyline);
        $this->assertInstanceOf(VariableAwareInterface::class, $this->polyline);
    }

    public function testDefaultState()
    {
        $this->assertStringStartsWith('polyline', $this->polyline->getVariable());
        $this->assertFalse($this->polyline->hasCoordinates());
        $this->assertFalse($this->polyline->hasIconSequences());
        $this->assertFalse($this->polyline->hasOptions());
    }

    public function testInitialState()
    {
        $this->polyline = new Polyline(
            $coordinates = [$coordinate = $this->createCoordinateMock()],
            $iconSequences = [$iconSequence = $this->createIconSequenceMock()],
            $options = ['foo' => 'bar']
        );

        $this->assertStringStartsWith('polyline', $this->polyline->getVariable());
        $this->assertTrue($this->polyline->hasIconSequences());
        $this->assertTrue($this->polyline->hasIconSequence($iconSequence));
        $this->assertSame($iconSequences, $this->polyline->getIconSequences());
        $this->assertTrue($this->polyline->hasCoordinates());
        $this->assertTrue($this->polyline->hasCoordinate($coordinate));
        $this->assertSame($coordinates, $this->polyline->getCoordinates());
        $this->assertSame($options, $this->polyline->getOptions());
    }

    public function testSetCoordinates()
    {
        $this->polyline->setCoordinates($coordinates = [$coordinate = $this->createCoordinateMock()]);
        $this->polyline->setCoordinates($coordinates);

        $this->assertTrue($this->polyline->hasCoordinates());
        $this->assertTrue($this->polyline->hasCoordinate($coordinate));
        $this->assertSame($coordinates, $this->polyline->getCoordinates());
    }

    public function testAddCoordinates()
    {
        $this->polyline->setCoordinates($firstCoordinates = [$this->createCoordinateMock()]);
        $this->polyline->addCoordinates($secondCoordinates = [$this->createCoordinateMock()]);

        $this->assertTrue($this->polyline->hasCoordinates());
        $this->assertSame([...$firstCoordinates, ...$secondCoordinates], $this->polyline->getCoordinates());
    }

    public function testAddCoordinate()
    {
        $this->polyline->addCoordinate($coordinate = $this->createCoordinateMock());

        $this->assertTrue($this->polyline->hasCoordinates());
        $this->assertTrue($this->polyline->hasCoordinate($coordinate));
        $this->assertSame([$coordinate], $this->polyline->getCoordinates());
    }

    public function testRemoveCoordinate()
    {
        $this->polyline->addCoordinate($coordinate = $this->createCoordinateMock());
        $this->polyline->removeCoordinate($coordinate);

        $this->assertFalse($this->polyline->hasCoordinates());
        $this->assertFalse($this->polyline->hasCoordinate($coordinate));
        $this->assertEmpty($this->polyline->getCoordinates());
    }

    public function testSetIconSequences()
    {
        $this->polyline->setIconSequences($iconSequences = [$iconSequence = $this->createIconSequenceMock()]);
        $this->polyline->setIconSequences($iconSequences);

        $this->assertTrue($this->polyline->hasIconSequences());
        $this->assertTrue($this->polyline->hasIconSequence($iconSequence));
        $this->assertSame($iconSequences, $this->polyline->getIconSequences());
    }

    public function testAddIconSequences()
    {
        $this->polyline->setIconSequences($firstIconSequences = [$this->createIconSequenceMock()]);
        $this->polyline->addIconSequences($secondIconSequences = [$this->createIconSequenceMock()]);

        $this->assertTrue($this->polyline->hasIconSequences());
        $this->assertSame([...$firstIconSequences, ...$secondIconSequences], $this->polyline->getIconSequences());
    }

    public function testAddIconSequence()
    {
        $this->polyline->addIconSequence($iconSequence = $this->createIconSequenceMock());

        $this->assertTrue($this->polyline->hasIconSequences());
        $this->assertTrue($this->polyline->hasIconSequence($iconSequence));
        $this->assertSame([$iconSequence], $this->polyline->getIconSequences());
    }

    public function testRemoveIconSequence()
    {
        $this->polyline->addIconSequence($iconSequence = $this->createIconSequenceMock());
        $this->polyline->removeIconSequence($iconSequence);

        $this->assertFalse($this->polyline->hasIconSequences());
        $this->assertFalse($this->polyline->hasIconSequence($iconSequence));
        $this->assertEmpty($this->polyline->getIconSequences());
    }

    private function createCoordinateMock(): MockObject|Coordinate
    {
        return $this->createMock(Coordinate::class);
    }

    private function createIconSequenceMock(): MockObject|IconSequence
    {
        return $this->createMock(IconSequence::class);
    }
}
