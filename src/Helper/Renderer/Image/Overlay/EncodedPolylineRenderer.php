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

use Ivory\GoogleMap\Overlay\EncodedPolyline;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class EncodedPolylineRenderer
{
    public function __construct(private readonly EncodedPolylineStyleRenderer $encodedPolylineStyleRenderer, private readonly EncodedPolylineValueRenderer $encodedPolylineValueRenderer)
    {
    }

    public function render(EncodedPolyline $encodedPolyline): string
    {
        $result = [];
        $style = $this->encodedPolylineStyleRenderer->render($encodedPolyline);

        if (!empty($style)) {
            $result[] = $style;
        }

        $result[] = $this->encodedPolylineValueRenderer->render($encodedPolyline);

        return implode('|', $result);
    }
}
