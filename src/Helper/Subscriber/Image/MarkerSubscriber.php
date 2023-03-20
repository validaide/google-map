<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Subscriber\Image;

use Ivory\GoogleMap\Helper\Collector\Image\MarkerCollector;
use Ivory\GoogleMap\Helper\Event\StaticMapEvent;
use Ivory\GoogleMap\Helper\Event\StaticMapEvents;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\MarkerRenderer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MarkerSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly MarkerCollector $markerCollector, private readonly MarkerRenderer $markerRenderer)
    {
    }

    public function handleMap(StaticMapEvent $event): void
    {
        $result = [];

        foreach ($this->markerCollector->collect($event->getMap()) as $markers) {
            $result[] = $this->markerRenderer->render($markers);
        }

        if (!empty($result)) {
            $event->setParameter('markers', $result);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [StaticMapEvents::MARKER => 'handleMap'];
    }
}
