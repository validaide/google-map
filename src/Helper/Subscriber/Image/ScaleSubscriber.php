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

use Ivory\GoogleMap\Helper\Event\StaticMapEvent;
use Ivory\GoogleMap\Helper\Event\StaticMapEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ScaleSubscriber implements EventSubscriberInterface
{
    public function handleMap(StaticMapEvent $event): void
    {
        $map = $event->getMap();

        if ($map->hasStaticOption('scale')) {
            $event->setParameter('scale', $map->getStaticOption('scale'));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [StaticMapEvents::SCALE => 'handleMap'];
    }
}
