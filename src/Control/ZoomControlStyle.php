<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Control;

/**
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html#ZoomControlStyle
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
final class ZoomControlStyle
{
    public const DEFAULT_ = 'default';
    public const LARGE = 'large';
    public const SMALL = 'small';

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }
}
