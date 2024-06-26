<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\TimeZone\Response;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
final class TimeZoneStatus
{
    public const OK = 'OK';
    public const INVALID_REQUEST = 'INVALID_REQUEST';
    public const OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    public const REQUEST_DENIED = 'REQUEST_DENIED';
    public const UNKNOWN_ERROR = 'UNKNOWN_ERROR';
    public const ZERO_RESULTS = 'ZERO_RESULTS';

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }
}
