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

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractHttpService extends AbstractService
{
    private ?ClientInterface $client = null;

    public function __construct(string $url, ClientInterface $client)
    {
        parent::__construct($url);

        $this->setClient(new GuzzleAdapter(new GuzzleClient()));
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    protected function createRequest(RequestInterface $request): PsrRequestInterface
    {
        return new Request('GET', $this->createUrl($request));
    }
}
