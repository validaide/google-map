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

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\TagRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class TagRendererTest extends TestCase
{
    private TagRenderer $tagRenderer;

    protected function setUp(): void
    {
        $this->tagRenderer = new TagRenderer(new Formatter());
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractRenderer::class, $this->tagRenderer);
    }

    /**
     * @param string      $expected
     * @param string      $name
     * @param string|null $code
     * @param string[]    $attributes
     * @param bool        $newLine
     * @param bool        $debug
     *
     * @dataProvider renderProvider
     */
    public function testRender(
        $expected,
        $name,
        $code = null,
        array $attributes = [],
        $newLine = false,
        $debug = false
    ) {
        $this->tagRenderer->getFormatter()->setDebug($debug);

        $this->assertSame($expected, $this->tagRenderer->render($name, $code, $attributes, $newLine));
    }

    /**
     * @return mixed[][]
     */
    public function renderProvider()
    {
        return [
            // Debug disabled
            ['<tag></tag>', 'tag'],
            ['<tag>code</tag>', 'tag', 'code'],
            ['<tag foo="bar"></tag>', 'tag', null, ['foo' => 'bar']],
            ['<tag></tag>', 'tag', null, [], false],
            ['<tag foo="bar">code</tag>', 'tag', 'code', ['foo' => 'bar'], true],

            // Debug enabled
            ['<tag></tag>'."\n", 'tag', null, [], true, true],
            ['<tag>'."\n".'    code'."\n".'</tag>'."\n", 'tag', 'code', [], true, true],
            ['<tag foo="bar"></tag>'."\n", 'tag', null, ['foo' => 'bar'], true, true],
            ['<tag></tag>', 'tag', null, [], false, true],
            ['<tag foo="bar">'."\n".'    code'."\n".'</tag>', 'tag', 'code', ['foo' => 'bar'], false, true],
        ];
    }
}
