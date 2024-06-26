<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Overlay;

/**
 * @see http://code.google.com/apis/maps/documentation/javascript/reference#Symbol
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
final class SymbolPath
{
    public const BACKWARD_CLOSED_ARROW = 'backward_closed_arrow';
    public const BACKWARD_OPEN_ARROW = 'backward_open_arrow';
    public const CIRCLE = 'circle';
    public const FORWARD_CLOSED_ARROW = 'forward_closed_arrow';
    public const FORWARD_OPEN_ARROW = 'forward_open_arrow';

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }
}
