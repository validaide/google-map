<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Renderer\Image\Overlay;

use Ivory\GoogleMap\Overlay\Polyline;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PolylineRenderer
{
    public function __construct(private readonly PolylineStyleRenderer $polylineStyleRenderer, private readonly PolylineLocationRenderer $polylineLocationRenderer)
    {
    }

    public function render(Polyline $polyline): string
    {
        $result = [];
        $style = $this->polylineStyleRenderer->render($polyline);

        if (!empty($style)) {
            $result[] = $style;
        }

        $result[] = $this->polylineLocationRenderer->render($polyline);

        return implode('|', $result);
    }
}
