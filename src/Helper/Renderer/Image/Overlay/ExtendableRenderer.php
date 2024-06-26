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

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Helper\Renderer\Image\Base\CoordinateRenderer;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\Polyline;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ExtendableRenderer
{
    public function __construct(private readonly CoordinateRenderer $coordinateRenderer, private readonly MarkerLocationRenderer $markerLocationRenderer, private readonly PolylineLocationRenderer $polylineLocationRenderer)
    {
    }

    /**
     * @param mixed[] $extendables
     */
    public function render(array $extendables): string
    {
        $result = [];

        foreach ($extendables as $value) {
            if ($value instanceof Coordinate) {
                $result[] = $this->coordinateRenderer->render($value);
            } elseif ($value instanceof Marker) {
                $result[] = $this->markerLocationRenderer->render($value);
            } elseif ($value instanceof Polyline) {
                $result[] = $this->polylineLocationRenderer->render($value);
            } else {
                $result[] = $value;
            }
        }

        return implode('|', $result);
    }
}
