<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Renderer\Html;

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\AbstractTagRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\TagRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class AbstractTagRendererTest extends TestCase
{
    private AbstractTagRenderer|MockObject $tagRenderer;

    private TagRenderer|MockObject $innerTagRenderer;

    protected function setUp(): void
    {
        $this->innerTagRenderer = $this->createTagRendererMock();
        $this->tagRenderer = $this->createAbstractTagRendererMock($this->innerTagRenderer);
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractRenderer::class, $this->tagRenderer);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->innerTagRenderer, $this->tagRenderer->getTagRenderer());
    }

    public function testTagRenderer()
    {
        $this->tagRenderer->setTagRenderer($tagRenderer = $this->createTagRendererMock());

        $this->assertSame($tagRenderer, $this->tagRenderer->getTagRenderer());
    }

    /**
     * @param TagRenderer|null $tagRenderer
     */
    private function createAbstractTagRendererMock(TagRenderer $tagRenderer = null): MockObject|AbstractTagRenderer
    {
        return $this->getMockBuilder(AbstractTagRenderer::class)
            ->setConstructorArgs([$this->createFormatterMock(), $tagRenderer ?: $this->createTagRendererMock()])
            ->getMockForAbstractClass();
    }

    private function createFormatterMock(): MockObject|Formatter
    {
        return $this->createMock(Formatter::class);
    }

    private function createTagRendererMock(): MockObject|TagRenderer
    {
        return $this->createMock(TagRenderer::class);
    }
}
