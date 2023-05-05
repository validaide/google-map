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

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractJsonRenderer;
use Ivory\GoogleMap\Helper\Renderer\AbstractRenderer;
use Validaide\Common\JsonBuilder\JsonBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class JsonRendererTest extends TestCase
{
    private AbstractJsonRenderer|MockObject $jsonRenderer;

    private MockObject|JsonBuilder $jsonBuilder;

    private Formatter|MockObject $formatter;

    protected function setUp(): void
    {
        $this->formatter = $this->createFormatterMock();
        $this->jsonBuilder = $this->createJsonBuilderMock();

        $this->jsonRenderer = $this->createAbstractJsonRendererMock($this->formatter, $this->jsonBuilder);
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractRenderer::class, $this->jsonRenderer);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->formatter, $this->jsonRenderer->getFormatter());
        $this->assertNotSame($this->jsonBuilder, $this->jsonRenderer->getJsonBuilder());
        $this->assertInstanceOf(JsonBuilder::class, $this->jsonRenderer->getJsonBuilder());
    }

    public function testJsonBuilder()
    {
        $this->jsonRenderer->setJsonBuilder($jsonBuilder = $this->createJsonBuilderMock());

        $this->assertNotSame($jsonBuilder, $this->jsonRenderer->getJsonBuilder());
        $this->assertInstanceOf(JsonBuilder::class, $this->jsonRenderer->getJsonBuilder());
    }

    /**
     * @param Formatter|null   $formatter
     * @param JsonBuilder|null $jsonBuilder
     */
    private function createAbstractJsonRendererMock(Formatter $formatter = null, JsonBuilder $jsonBuilder = null): MockObject|AbstractJsonRenderer
    {
        return $this->getMockBuilder(AbstractJsonRenderer::class)
            ->setConstructorArgs([
                $formatter ?: $this->createFormatterMock(),
                $jsonBuilder ?: $this->createJsonBuilderMock(),
            ])
            ->getMockForAbstractClass();
    }

    private function createFormatterMock(): MockObject|Formatter
    {
        return $this->createMock(Formatter::class);
    }

    private function createJsonBuilderMock(): MockObject|JsonBuilder
    {
        $jsonBuilder = $this->createMock(JsonBuilder::class);
        $jsonBuilder
            ->expects($this->any())
            ->method('reset')
            ->will($this->returnSelf());

        $jsonBuilder
            ->expects($this->any())
            ->method('setJsonEncodeOptions')
            ->will($this->returnSelf());

        return $jsonBuilder;
    }
}
