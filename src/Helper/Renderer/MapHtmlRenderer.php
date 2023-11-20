<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Renderer;

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\Html\AbstractTagRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\StylesheetRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\TagRenderer;
use Ivory\GoogleMap\Map;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MapHtmlRenderer extends AbstractTagRenderer
{
    private ?StylesheetRenderer $stylesheetRenderer = null;

    public function __construct(Formatter $formatter, TagRenderer $tagRenderer, StylesheetRenderer $stylesheetRenderer)
    {
        parent::__construct($formatter, $tagRenderer);

        $this->setStylesheetRenderer($stylesheetRenderer);
    }

    public function getStylesheetRenderer(): StylesheetRenderer
    {
        return $this->stylesheetRenderer;
    }

    public function setStylesheetRenderer(StylesheetRenderer $stylesheetRenderer): void
    {
        $this->stylesheetRenderer = $stylesheetRenderer;
    }

    public function render(Map $map): string
    {
        $styles      = [];
        $stylesheets = [];
        if ($map->hasStylesheetOption('width')) {
            $stylesheets['width'] = $map->getStylesheetOption('width');
        }

        if ($map->hasStylesheetOption('height')) {
            $stylesheets['height'] = $map->getStylesheetOption('height');
        }

        foreach ($stylesheets as $stylesheet => $value) {
            $styles[] = $this->stylesheetRenderer->render($stylesheet, $value);
        }

        $attributes = array_merge($map->getHtmlAttributes(), [
            'id' => $map->getHtmlId(),
        ]);

        if (!empty($stylesheets)) {
            $attributes['style'] = implode('', $styles);
        }

        return $this->getTagRenderer()->render('div', null, $attributes);
    }
}
