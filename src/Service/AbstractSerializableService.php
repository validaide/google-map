<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service;

use Http\Client\HttpClient;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractSerializableService extends AbstractHttpService
{
    final public const FORMAT_JSON = 'json';
    final public const FORMAT_XML  = 'xml';

    private SerializerInterface $serializer;

    public function __construct(string $url, HttpClient $client, ?SerializerInterface $serializer = null)
    {
        parent::__construct($url, $client);

        $this->setSerializer($serializer ?: SerializerBuilder::create());
    }

    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function createBaseUrl(RequestInterface $request): string
    {
        return parent::createBaseUrl($request) . '/json';
    }

    /**
     * @return object
     */
    protected function deserialize(ResponseInterface $response, string $type, ?array $context = null)
    {
        return $this->serializer->deserialize((string)$response->getBody(), $type, 'json', $context);
    }
}
