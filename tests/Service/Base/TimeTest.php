<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service\Base;

use DateTime;
use Ivory\GoogleMap\Service\Base\Time;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class TimeTest extends TestCase
{
    private Time $time;

    private ?DateTime $value = null;

    private ?string $timeZone = null;

    private ?string $text = null;

    protected function setUp(): void
    {
        $this->time = new Time(
            $this->value = new DateTime(),
            $this->timeZone = 'Europe/Paris',
            $this->text = 'text'
        );
    }

    public function testDefaultState()
    {
        $this->assertSame($this->value, $this->time->getValue());
        $this->assertSame($this->timeZone, $this->time->getTimeZone());
        $this->assertSame($this->text, $this->time->getText());
    }

    public function testValue()
    {
        $this->time->setValue($value = new DateTime());

        $this->assertSame($value, $this->time->getValue());
    }

    public function testTimeZone()
    {
        $this->time->setTimeZone($timeZone = 'Europe/Berlin');

        $this->assertSame($timeZone, $this->time->getTimeZone());
    }

    public function testText()
    {
        $this->time->setText($text = 'foo');

        $this->assertSame($text, $this->time->getText());
    }
}
