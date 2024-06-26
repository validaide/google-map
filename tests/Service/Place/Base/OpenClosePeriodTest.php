<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service\Place\Base;

use Ivory\GoogleMap\Service\Place\Base\DayOfWeek;
use Ivory\GoogleMap\Service\Place\Base\OpenClosePeriod;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class OpenClosePeriodTest extends TestCase
{
    private OpenClosePeriod $openClosePeriod;

    protected function setUp(): void
    {
        $this->openClosePeriod = new OpenClosePeriod();
    }

    public function testDefaultState()
    {
        $this->assertFalse($this->openClosePeriod->hasDay());
        $this->assertNull($this->openClosePeriod->getDay());
        $this->assertFalse($this->openClosePeriod->hasTime());
        $this->assertNull($this->openClosePeriod->getTime());
    }

    public function testDay()
    {
        $this->openClosePeriod->setDay($day = DayOfWeek::SUNDAY);

        $this->assertTrue($this->openClosePeriod->hasDay());
        $this->assertSame($day, $this->openClosePeriod->getDay());
    }

    public function testTime()
    {
        $this->openClosePeriod->setTime($time = '0800');

        $this->assertTrue($this->openClosePeriod->hasTime());
        $this->assertSame($time, $this->openClosePeriod->getTime());
    }
}
