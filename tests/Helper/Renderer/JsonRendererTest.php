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
use Ivory\GoogleMap\Helper\Renderer\AbstractJsonRenderer;
use Ivory\GoogleMap\Helper\Renderer\AbstractRenderer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class JsonRendererTest extends TestCase
{
    /** @var AbstractJsonRenderer|MockObject */
    private $jsonRenderer;
    /** @var Serializer|MockObject */
    private $serializer;
    /** @var Formatter|MockObject */
    private $formatter;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->formatter  = $this->createFormatterMock();
        $this->serializer = $this->createSerializerMock();

        $this->jsonRenderer = $this->createAbstractJsonRendererMock($this->formatter, $this->serializer);
    }

    /*****************************************************************************/
    /* Tests
    /*****************************************************************************/

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractRenderer::class, $this->jsonRenderer);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->formatter, $this->jsonRenderer->getFormatter());
        $this->assertSame($this->serializer, $this->jsonRenderer->getSerializer());
        $this->assertInstanceOf(Serializer::class, $this->jsonRenderer->getSerializer());
    }

    public function testJsonBuilder()
    {
        $this->jsonRenderer->setSerializer($jsonBuilder = $this->createSerializerMock());

        $this->assertSame($jsonBuilder, $this->jsonRenderer->getSerializer());
        $this->assertInstanceOf(Serializer::class, $this->jsonRenderer->getSerializer());
    }

    /**
     * @param Formatter|null  $formatter
     * @param Serializer|null $serializer
     *
     * @return MockObject|AbstractJsonRenderer
     */
    private function createAbstractJsonRendererMock(Formatter $formatter = null, Serializer $serializer = null)
    {
        return $this->getMockBuilder(AbstractJsonRenderer::class)
            ->setConstructorArgs([
                $formatter ?: $this->createFormatterMock(),
                $serializer ?: $this->createSerializerMock(),
            ])
            ->getMockForAbstractClass();
    }

    /**
     * @return MockObject|Formatter
     */
    private function createFormatterMock()
    {
        return $this->createMock(Formatter::class);
    }

    /**
     * @return MockObject|Serializer
     */
    private function createSerializerMock()
    {
        return $this->createMock(Serializer::class);
    }
}
