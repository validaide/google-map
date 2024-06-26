<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Subscriber;

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractSubscriber implements EventSubscriberInterface
{
    private ?Formatter $formatter = null;

    public function __construct(Formatter $formatter)
    {
        $this->setFormatter($formatter);
    }

    public function getFormatter(): Formatter
    {
        return $this->formatter;
    }

    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }
}
