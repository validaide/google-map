<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\Place\Search\Request;

use Ivory\GoogleMap\Base\Coordinate;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class NearbyPlaceSearchRequest extends AbstractTextualPlaceSearchRequest
{
    private ?string $rankBy = null;

    /**
     * @param string     $rankBy
     * @param float|null $radius
     */
    public function __construct(Coordinate $location, $rankBy, $radius = null)
    {
        $this->setLocation($location);
        $this->setRankBy($rankBy);
        $this->setRadius($radius);
    }

    public function getRankBy(): string
    {
        return $this->rankBy;
    }

    /**
     * @param string $rankBy
     */
    public function setRankBy($rankBy): void
    {
        $this->rankBy = $rankBy;
    }

    public function buildContext(): string
    {
        return 'nearbysearch';
    }

    public function buildQuery(): array
    {
        $query = parent::buildQuery();
        $query['rankby'] = $this->rankBy;

        return $query;
    }
}
