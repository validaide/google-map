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
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Ivory\GoogleMap\Service\AbstractHttpService;
use Ivory\GoogleMap\Service\AbstractSerializableService;
use Ivory\GoogleMap\Service\BusinessAccount;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class SerializableServiceTest extends TestCase
{
    /** @var MockObject|AbstractSerializableService  */
    private MockObject $service;

    private ?string $url = null;

    /**
     * @var HttpClient|MockObject|null
     */
    private HttpClient|MockObject|null $client = null;

    /**
     * @var MessageFactory|MockObject
     */
    private $messageFactory;

    /**
     * @var MockObject|SerializerInterface|null
     */
    private MockObject|SerializerInterface|null $serializer = null;

    protected function setUp(): void
    {
        $this->service = $this->getMockBuilder(AbstractSerializableService::class)
            ->setConstructorArgs([
                $this->url = 'https://foo',
                $this->client = $this->createHttpClientMock(),
                $this->serializer = $this->createSerializerMock(),
            ])
            ->getMockForAbstractClass();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractHttpService::class, $this->service);
    }

    public function testDefaultState()
    {
        $this->assertSame('https://foo', $this->service->getUrl());
        $this->assertSame($this->client, $this->service->getClient());
        $this->assertSame($this->serializer, $this->service->getSerializer());
        $this->assertFalse($this->service->hasKey());
        $this->assertNull($this->service->getKey());
        $this->assertFalse($this->service->hasBusinessAccount());
        $this->assertNull($this->service->getBusinessAccount());
    }

    public function testUrl()
    {
        $this->assertSame($this->url, $this->service->getUrl());
    }

    public function testClient()
    {
        $this->service->setClient($client = $this->createHttpClientMock());

        $this->assertSame($client, $this->service->getClient());
    }

    public function testSerializer()
    {
        $this->service->setSerializer($serializer = $this->createSerializerMock());

        $this->assertSame($serializer, $this->service->getSerializer());
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

    private function createHttpClientMock(): MockObject|HttpClient
    {
        return $this->createMock(HttpClient::class);
    }
    private function createSerializerMock(): MockObject|SerializerInterface
    {
        return $this->createMock(SerializerInterface::class);
    }

    private function createBusinessAccountMock(): MockObject|BusinessAccount
    {
        return $this->createMock(BusinessAccount::class);
    }
}
