<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Layer;

use Ivory\GoogleMap\Utility\OptionsAwareInterface;
use Ivory\GoogleMap\Utility\OptionsAwareTrait;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class GeoJsonLayer implements OptionsAwareInterface
{
    use OptionsAwareTrait;

    private ?string $url = null;

    /**
     * @param string  $url
     * @param mixed[] $options
     */
    public function __construct($url, array $options = [])
    {
        $this->setUrl($url);
        $this->setOptions($options);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }
}
