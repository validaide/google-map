<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\Direction;

use Http\Client\Exception;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Ivory\GoogleMap\Service\AbstractSerializableService;
use Ivory\GoogleMap\Service\Direction\Request\DirectionRequestInterface;
use Ivory\GoogleMap\Service\Direction\Response\DirectionResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DirectionService extends AbstractSerializableService
{
    /**
     * @param HttpClient               $client
     * @param MessageFactory           $messageFactory
     * @param SerializerInterface|null $serializer
     */
    public function __construct(HttpClient $client, MessageFactory $messageFactory, SerializerInterface $serializer = null)
    {
        parent::__construct('https://maps.googleapis.com/maps/api/directions', $client, $messageFactory, $serializer);
    }

    /**
     * @param DirectionRequestInterface $request
     *
     * @return array|object
     * @throws Exception
     */
    public function route(DirectionRequestInterface $request)
    {
        $httpRequest  = $this->createRequest($request);
        $httpResponse = $this->getClient()->sendRequest($httpRequest);

        $response = $this->deserialize($httpResponse, DirectionResponse::class);

        // (new Context())->setNamingStrategy(new SnakeCaseNamingStrategy())

        $response->setRequest($request);

        return $response;
    }
}
