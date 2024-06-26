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
use Ivory\GoogleMap\Helper\Renderer\Html\AbstractTagRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\JavascriptTagRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\TagRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class JavascriptTagRendererTest extends TestCase
{
    private JavascriptTagRenderer $javascriptTagRenderer;

    protected function setUp(): void
    {
        $this->javascriptTagRenderer = new JavascriptTagRenderer(
            $formatter = new Formatter(),
            new TagRenderer($formatter)
        );
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractTagRenderer::class, $this->javascriptTagRenderer);
    }

    /**
     * @param string      $expected
     * @param string|null $code
     * @param string[]    $attributes
     * @param bool        $newLine
     * @param bool        $debug
     *
     * @dataProvider renderProvider
     */
    public function testRender($expected, $code = null, array $attributes = [], $newLine = true, $debug = false)
    {
        $this->javascriptTagRenderer->getFormatter()->setDebug($debug);

        $this->assertSame($expected, $this->javascriptTagRenderer->render($code, $attributes, $newLine));
    }

    /**
     * @return mixed[][]
     */
    public function renderProvider()
    {
        return [
            // Debug disabled
            ['<script type="text/javascript"></script>'],
            ['<script type="text/javascript">code</script>', 'code'],
            ['<script type="text/javascript" foo="bar"></script>', null, ['foo' => 'bar']],
            ['<script type="text/javascript"></script>', null, [], false],
            ['<script type="text/javascript" foo="bar">code</script>', 'code', ['foo' => 'bar'], false],

            // Debug enabled
            ['<script type="text/javascript"></script>'."\n", null, [], true, true],
            ['<script type="text/javascript">'."\n".'    code'."\n".'</script>'."\n", 'code', [], true, true],
            ['<script type="text/javascript" foo="bar"></script>'."\n", null, ['foo' => 'bar'], true, true],
            ['<script type="text/javascript"></script>', null, [], false, true],
            ['<script type="text/javascript" foo="bar">'."\n".'    code'."\n".'</script>', 'code', ['foo' => 'bar'], false, true],
        ];
    }
}
