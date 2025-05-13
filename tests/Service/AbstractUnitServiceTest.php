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

use Ivory\GoogleMap\Service\BusinessAccount;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractUnitServiceTest extends TestCase
{
    protected MockObject|ClientInterface     $client;
    protected MockObject|SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->client     = $this->createHttpClientMock();
        $this->serializer = $this->createSerializerMock();
    }

    protected function createHttpClientMock(): MockObject|ClientInterface
    {
        return $this->createMock(ClientInterface::class);
    }

    protected function createSerializerMock(): MockObject|SerializerInterface
    {
        return $this->createMock(SerializerInterface::class);
    }

    protected function createHttpRequestMock(): MockObject|RequestInterface
    {
        return $this->createMock(RequestInterface::class);
    }

    protected function createHttpResponseMock(): MockObject|ResponseInterface
    {
        return $this->createMock(ResponseInterface::class);
    }

    protected function createHttpStreamMock(): MockObject|StreamInterface
    {
        return $this->createMock(StreamInterface::class);
    }

    protected function createBusinessAccountMock(): MockObject|BusinessAccount
    {
        return $this->createMock(BusinessAccount::class);
    }
}
