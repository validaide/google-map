<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Renderer\Place;

use Ivory\GoogleMap\Helper\Renderer\AbstractJsonRenderer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class AutocompleteContainerRenderer extends AbstractJsonRenderer
{
    /**
     * @return string
     */
    public function render()
    {
        $data = [];

        $data['base']['coordinates']       = [];
        $data['base']['bounds']            = [];
        $data['autocomplete']              = null;
        $data['events']['dom_events']      = [];
        $data['events']['dom_events_once'] = [];
        $data['events']['events']          = [];
        $data['events']['events_once']     = [];

        return $this->getSerializer()->serialize($data, 'json');
    }
}
