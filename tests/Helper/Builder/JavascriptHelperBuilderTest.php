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

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Helper\Builder\AbstractHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\AbstractJavascriptHelperBuilder;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Validaide\Common\JsonBuilder\JsonBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class JavascriptHelperBuilderTest extends TestCase
{
    private AbstractJavascriptHelperBuilder|MockObject $helperBuilder;

    protected function setUp(): void
    {
        $this->helperBuilder = $this->createAbstractJavascriptHelperBuilder();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractHelperBuilder::class, $this->helperBuilder);
    }

    public function testDefaultState()
    {
        $this->assertInstanceOf(Formatter::class, $this->helperBuilder->getFormatter());
        $this->assertInstanceOf(JsonBuilder::class, $this->helperBuilder->getJsonBuilder());
    }

    public function testInitialState()
    {
        $this->helperBuilder = $this->createAbstractJavascriptHelperBuilder(
            $formatter = $this->createFormatterMock(),
            $jsonBuilder = $this->createJsonBuilderMock()
        );

        $this->assertSame($formatter, $this->helperBuilder->getFormatter());
        $this->assertSame($jsonBuilder, $this->helperBuilder->getJsonBuilder());
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
            $this->helperBuilder->setJsonBuilder($jsonBuilder = $this->createJsonBuilderMock())
        );

        $this->assertSame($jsonBuilder, $this->helperBuilder->getJsonBuilder());
    }

    /**
     * @param Formatter|null   $formatter
     * @param JsonBuilder|null $jsonBuilder
     */
    private function createAbstractJavascriptHelperBuilder(Formatter $formatter = null, JsonBuilder $jsonBuilder = null): MockObject|AbstractJavascriptHelperBuilder
    {
        return $this->getMockBuilder(AbstractJavascriptHelperBuilder::class)
            ->setConstructorArgs([$formatter, $jsonBuilder])
            ->getMockForAbstractClass();
    }

    private function createFormatterMock(): MockObject|Formatter
    {
        return $this->createMock(Formatter::class);
    }

    private function createJsonBuilderMock(): MockObject|JsonBuilder
    {
        return $this->createMock(JsonBuilder::class);
    }
}
