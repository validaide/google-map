<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Collector\Place\Event;

use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Helper\Collector\Place\Event\AutocompleteDomEventOnceCollector;
use Ivory\GoogleMap\Place\Autocomplete;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class AutocompleteDomEventOnceCollectorTest extends TestCase
{
    private AutocompleteDomEventOnceCollector $domEventOnceCollector;

    protected function setUp(): void
    {
        $this->domEventOnceCollector = new AutocompleteDomEventOnceCollector();
    }

    public function testCollect()
    {
        $autocomplete = new Autocomplete();
        $autocomplete->getEventManager()->addDomEventOnce($event = new Event('handle', 'trigger', 'handle'));

        $this->assertSame([$event], $this->domEventOnceCollector->collect($autocomplete));
    }
}
