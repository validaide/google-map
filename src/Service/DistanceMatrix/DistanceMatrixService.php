<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\DistanceMatrix;

use Http\Client\Exception;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Ivory\GoogleMap\Service\AbstractSerializableService;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequestInterface;
use Ivory\GoogleMap\Service\DistanceMatrix\Response\DistanceMatrixResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DistanceMatrixService extends AbstractSerializableService
{
    /**
     * @param HttpClient               $client
     * @param MessageFactory           $messageFactory
     * @param SerializerInterface|null $serializer
     */
    public function __construct(HttpClient $client, MessageFactory $messageFactory, SerializerInterface $serializer = null)
    {
        parent::__construct(
            'https://maps.googleapis.com/maps/api/distancematrix',
            $client,
            $messageFactory,
            $serializer
        );
    }

    /**
     * @param DistanceMatrixRequestInterface $request
     *
     * @return array|object
     * @throws Exception
     */
    public function process(DistanceMatrixRequestInterface $request)
    {
        $httpRequest  = $this->createRequest($request);
        $httpResponse = $this->getClient()->sendRequest($httpRequest);

        $response = $this->deserialize(
            $httpResponse,
            DistanceMatrixResponse::class
        );

        //(new Context())->setNamingStrategy(new SnakeCaseNamingStrategy())

        $response->setRequest($request);

        return $response;
    }
}
