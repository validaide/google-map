<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Service\AbstractService;
use Ivory\GoogleMap\Service\BusinessAccount;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ServiceTest extends TestCase
{
    /** @var MockObject|AbstractService  */
    private MockObject $service;

    protected function setUp(): void
    {
        $this->service = $this->getMockBuilder(AbstractService::class)
            ->setConstructorArgs(['https://foo'])
            ->getMockForAbstractClass();
    }

    public function testDefaultState()
    {
        $this->assertSame('https://foo', $this->service->getUrl());
        $this->assertFalse($this->service->hasKey());
        $this->assertNull($this->service->getKey());
        $this->assertFalse($this->service->hasBusinessAccount());
        $this->assertNull($this->service->getBusinessAccount());
    }

    public function testUrl()
    {
        $this->assertSame('https://foo', $this->service->getUrl());
    }

    public function testKey()
    {
        $this->service->setKey($key = 'key');

        $this->assertTrue($this->service->hasKey());
        $this->assertSame($key, $this->service->getKey());
    }

    public function testResetKey()
    {
        $this->service->setKey($key = 'key');
        $this->service->setKey(null);

        $this->assertFalse($this->service->hasKey());
        $this->assertNull($this->service->getKey());
    }

    public function testBusinessAccount()
    {
        $this->service->setBusinessAccount($businessAccount = $this->createBusinessAccountMock());

        $this->assertTrue($this->service->hasBusinessAccount());
        $this->assertSame($businessAccount, $this->service->getBusinessAccount());
    }

    public function testResetBusinessAccount()
    {
        $this->service->setBusinessAccount($this->createBusinessAccountMock());
        $this->service->setBusinessAccount();

        $this->assertFalse($this->service->hasBusinessAccount());
        $this->assertNull($this->service->getBusinessAccount());
    }

    private function createBusinessAccountMock(): MockObject|BusinessAccount
    {
        return $this->createMock(BusinessAccount::class);
    }
}
