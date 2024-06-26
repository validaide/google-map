<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Event;

use Ivory\GoogleMap\Place\Autocomplete;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PlaceAutocompleteEvent extends AbstractEvent
{
    public function __construct(private readonly Autocomplete $autocomplete)
    {
    }

    public function getAutocomplete(): Autocomplete
    {
        return $this->autocomplete;
    }
}
