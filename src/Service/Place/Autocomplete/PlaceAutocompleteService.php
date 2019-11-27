<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\Place\Autocomplete;

use Http\Client\Exception;
use Ivory\GoogleMap\Service\Place\AbstractPlaceSerializableService;
use Ivory\GoogleMap\Service\Place\Autocomplete\Request\PlaceAutocompleteRequestInterface;
use Ivory\GoogleMap\Service\Place\Autocomplete\Response\PlaceAutocompleteResponse;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PlaceAutocompleteService extends AbstractPlaceSerializableService
{
    /**
     * @param PlaceAutocompleteRequestInterface $request
     *
     * @return array|object
     * @throws Exception
     */
    public function process(PlaceAutocompleteRequestInterface $request)
    {
        $httpRequest  = $this->createRequest($request);
        $httpResponse = $this->getClient()->sendRequest($httpRequest);
        $response     = $this->deserialize($httpResponse, PlaceAutocompleteResponse::class);

        // (new Context())->setNamingStrategy(new SnakeCaseNamingStrategy())

        $response->setRequest($request);

        return $response;
    }
}
