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
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractSerializableService extends AbstractHttpService
{
    const FORMAT_JSON = 'json';
    const FORMAT_XML  = 'xml';

    /** @var SerializerInterface */
    private $serializer;
    /** @var string */
    private $format = self::FORMAT_JSON;

    /**
     * @param                          $url
     * @param HttpClient               $client
     * @param MessageFactory           $messageFactory
     * @param SerializerInterface|null $serializer
     */
    public function __construct(
        $url,
        HttpClient $client,
        MessageFactory $messageFactory,
        SerializerInterface $serializer = null
    )
    {
        parent::__construct($url, $client, $messageFactory);

        // $this->setSerializer($serializer ?: new Serializer());
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * {@inheritdoc}
     */
    protected function createBaseUrl(RequestInterface $request)
    {
        return parent::createBaseUrl($request) . '/' . $this->format;
    }

    /**
     * @param ResponseInterface $response
     * @param string            $type
     * @param array             $context
     *
     * @return array|object
     */
    protected function deserialize(ResponseInterface $response, string $type, array $context = [])
    {
        return $this->serializer->deserialize((string)$response->getBody(), $type, $this->format, $context);
    }
}
