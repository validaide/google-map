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

use Ivory\GoogleMap\Service\Place\Search\Request\AbstractPlaceSearchRequest;
use Ivory\GoogleMap\Service\Place\Search\Request\TextPlaceSearchRequest;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class TextPlaceSearchRequestTest extends TestCase
{
    private TextPlaceSearchRequest $request;

    private ?string $query = null;

    protected function setUp(): void
    {
        $this->request = new TextPlaceSearchRequest($this->query = 'foo');
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractPlaceSearchRequest::class, $this->request);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->query, $this->request->getQuery());
    }

    public function testQuery()
    {
        $this->request->setQuery($query = 'query');

        $this->assertSame($query, $this->request->getQuery());
    }

    public function testMethod()
    {
        $this->assertSame('textsearch', $this->request->buildContext());
    }

    public function testBuild()
    {
        $this->assertSame(['query' => $this->query], $this->request->buildQuery());
    }
}
