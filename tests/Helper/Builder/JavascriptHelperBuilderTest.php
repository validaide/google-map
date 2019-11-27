<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Builder;

use Ivory\GoogleMap\Helper\Builder\AbstractHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\AbstractJavascriptHelperBuilder;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class JavascriptHelperBuilderTest extends TestCase
{
    /** @var AbstractJavascriptHelperBuilder */
    private $helperBuilder;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->helperBuilder = $this->createAbstractJavascriptHelperBuilder(new Formatter(), new Serializer());
    }

    /*****************************************************************************/
    /* Tests
    /*****************************************************************************/

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractHelperBuilder::class, $this->helperBuilder);
    }

    public function testDefaultState()
    {
        $this->assertInstanceOf(Formatter::class, $this->helperBuilder->getFormatter());
        $this->assertInstanceOf(Serializer::class, $this->helperBuilder->getSerializer());
    }

    public function testInitialState()
    {
        $this->helperBuilder = $this->createAbstractJavascriptHelperBuilder(
            $formatter = $this->createFormatterMock(),
            $jsonBuilder = $this->createSerializerMock()
        );

        $this->assertSame($formatter, $this->helperBuilder->getFormatter());
        $this->assertSame($jsonBuilder, $this->helperBuilder->getSerializer());
    }

    public function testFormatter()
    {
        $this->assertSame(
            $this->helperBuilder,
            $this->helperBuilder->setFormatter($formatter = $this->createFormatterMock())
        );

        $this->assertSame($formatter, $this->helperBuilder->getFormatter());
    }

    public function testJsonBuilder()
    {
        $this->assertSame(
            $this->helperBuilder,
            $this->helperBuilder->setSerializer($jsonBuilder = $this->createSerializerMock())
        );

        $this->assertSame($jsonBuilder, $this->helperBuilder->getSerializer());
    }

    /*****************************************************************************/
    /* Helpers
    /*****************************************************************************/

    /**
     * @param Formatter|null  $formatter
     * @param Serializer|null $serializer
     *
     * @return MockObject|AbstractJavascriptHelperBuilder
     */
    private function createAbstractJavascriptHelperBuilder(Formatter $formatter = null, Serializer $serializer = null)
    {
        return $this->getMockBuilder(AbstractJavascriptHelperBuilder::class)
            ->setConstructorArgs([$formatter, $serializer])
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
