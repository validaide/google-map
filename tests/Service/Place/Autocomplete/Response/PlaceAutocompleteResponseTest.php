<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service\Place\Autocomplete\Response;

use PHPUnit\Framework\MockObject\MockObject;
use Ivory\GoogleMap\Service\Place\Autocomplete\Request\PlaceAutocompleteRequestInterface;
use Ivory\GoogleMap\Service\Place\Autocomplete\Response\PlaceAutocompletePrediction;
use Ivory\GoogleMap\Service\Place\Autocomplete\Response\PlaceAutocompleteResponse;
use Ivory\GoogleMap\Service\Place\Autocomplete\Response\PlaceAutocompleteStatus;
use PHPUnit\Framework\TestCase;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PlaceAutocompleteResponseTest extends TestCase
{
    private PlaceAutocompleteResponse $response;

    protected function setUp(): void
    {
        $this->response = new PlaceAutocompleteResponse();
    }

    public function testDefaultState()
    {
        $this->assertFalse($this->response->hasStatus());
        $this->assertNull($this->response->getStatus());
        $this->assertFalse($this->response->hasRequest());
        $this->assertNull($this->response->getRequest());
        $this->assertFalse($this->response->hasPredictions());
        $this->assertEmpty($this->response->getPredictions());
    }

    public function testStatus()
    {
        $this->response->setStatus($status = PlaceAutocompleteStatus::OK);

        $this->assertTrue($this->response->hasStatus());
        $this->assertSame($status, $this->response->getStatus());
    }

    public function testRequest()
    {
        $this->response->setRequest($request = $this->createRequestMock());

        $this->assertTrue($this->response->hasRequest());
        $this->assertSame($request, $this->response->getRequest());
    }

    public function testSetPredictions()
    {
        $this->response->setPredictions($predictions = [$prediction = $this->createPredictionMock()]);
        $this->response->setPredictions($predictions);

        $this->assertTrue($this->response->hasPredictions());
        $this->assertTrue($this->response->hasPrediction($prediction));
        $this->assertSame($predictions, $this->response->getPredictions());
    }

    public function testAddPredictions()
    {
        $this->response->setPredictions($firstPredictions = [$this->createPredictionMock()]);
        $this->response->addPredictions($secondPredictions = [$this->createPredictionMock()]);

        $this->assertTrue($this->response->hasPredictions());
        $this->assertSame([...$firstPredictions, ...$secondPredictions], $this->response->getPredictions());
    }

    public function testAddPrediction()
    {
        $this->response->addPrediction($prediction = $this->createPredictionMock());

        $this->assertTrue($this->response->hasPredictions());
        $this->assertTrue($this->response->hasPrediction($prediction));
        $this->assertSame([$prediction], $this->response->getPredictions());
    }

    public function testRemovePrediction()
    {
        $this->response->addPrediction($prediction = $this->createPredictionMock());
        $this->response->removePrediction($prediction);

        $this->assertFalse($this->response->hasPredictions());
        $this->assertFalse($this->response->hasPrediction($prediction));
        $this->assertEmpty($this->response->getPredictions());
    }

    private function createRequestMock(): MockObject|PlaceAutocompleteRequestInterface
    {
        return $this->createMock(PlaceAutocompleteRequestInterface::class);
    }

    private function createPredictionMock(): MockObject|PlaceAutocompletePrediction
    {
        return $this->createMock(PlaceAutocompletePrediction::class);
    }
}
