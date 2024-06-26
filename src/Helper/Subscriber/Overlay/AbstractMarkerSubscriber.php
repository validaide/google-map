<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Subscriber\Overlay;

use Ivory\GoogleMap\Helper\Collector\Overlay\MarkerCollector;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Subscriber\AbstractSubscriber;

/**
 * Marker subscriber.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractMarkerSubscriber extends AbstractSubscriber
{
    private ?MarkerCollector $markerCollector = null;

    public function __construct(Formatter $formatter, MarkerCollector $markerCollector)
    {
        parent::__construct($formatter);

        $this->setMarkerCollector($markerCollector);
    }

    public function getMarkerCollector(): MarkerCollector
    {
        return $this->markerCollector;
    }

    public function setMarkerCollector(MarkerCollector $markerCollector)
    {
        $this->markerCollector = $markerCollector;
    }
}
