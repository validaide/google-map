<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service\Place\Search\Request;

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Service\ContextualizedRequestInterface;
use Ivory\GoogleMap\Service\Place\Search\Request\PageTokenPlaceSearchRequest;
use Ivory\GoogleMap\Service\Place\Search\Request\PlaceSearchRequestInterface;
use Ivory\GoogleMap\Service\Place\Search\Response\PlaceSearchResponse;
use Ivory\GoogleMap\Service\RequestInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PageTokenPlaceSearchRequestTest extends TestCase
{
    private PageTokenPlaceSearchRequest $request;

    /**
     * @var PlaceSearchResponse|MockObject|null
     */
    private PlaceSearchResponse|MockObject|null $response = null;

    protected function setUp(): void
    {
        $this->request = new PageTokenPlaceSearchRequest($this->response = $this->createResponseMock());
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(PlaceSearchRequestInterface::class, $this->request);
        $this->assertInstanceOf(ContextualizedRequestInterface::class, $this->request);
        $this->assertInstanceOf(RequestInterface::class, $this->request);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->response, $this->request->getResponse());
    }

    public function testResponse()
    {
        $this->request->setResponse($response = $this->createResponseMock());

        $this->assertSame($response, $this->request->getResponse());
    }

    public function testBuildContext()
    {
        $this->response
            ->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request = $this->createRequestMock()));

        $request
            ->expects($this->once())
            ->method('buildContext')
            ->will($this->returnValue($method = 'method'));

        $this->assertSame($method, $this->request->buildContext());
    }

    public function testBuildQuery()
    {
        $this->response
            ->expects($this->once())
            ->method('getNextPageToken')
            ->will($this->returnValue($pageToken = 'token'));

        $this->assertSame(['pagetoken' => $pageToken], $this->request->buildQuery());
    }

    private function createResponseMock(): MockObject|PlaceSearchResponse
    {
        return $this->createMock(PlaceSearchResponse::class);
    }

    private function createRequestMock(): MockObject|PlaceSearchRequestInterface
    {
        return $this->createMock(PlaceSearchRequestInterface::class);
    }
}
