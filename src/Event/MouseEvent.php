<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Event;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
final class MouseEvent
{
    public const CLICK = 'click';
    public const DBLCLICK = 'dblclick';
    public const MOUSEUP = 'mouseup';
    public const MOUSEDOWN = 'mousedown';
    public const MOUSEOVER = 'mouseover';
    public const MOUSEOUT = 'mouseout';

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }
}
