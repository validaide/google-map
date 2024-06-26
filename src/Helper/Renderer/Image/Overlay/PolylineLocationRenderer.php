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
use Ivory\GoogleMap\Overlay\Polyline;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PolylineLocationRenderer
{
    public function __construct(private readonly CoordinateRenderer $coordinateRenderer)
    {
    }

    public function render(Polyline $polyline): string
    {
        if ($polyline->hasStaticOption('locations')) {
            $locations = $polyline->getStaticOption('locations');
        } else {
            $locations = $polyline->getCoordinates();
        }

        return implode('|', array_map(fn($location) => $location instanceof Coordinate ? $this->coordinateRenderer->render($location) : $location, $locations));
    }
}
