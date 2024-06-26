<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Overlay;

use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Utility\OptionsAwareInterface;
use Ivory\GoogleMap\Utility\OptionsAwareTrait;
use Ivory\GoogleMap\Utility\VariableAwareTrait;

/**
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html#GroundOverlay
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GroundOverlay implements ExtendableInterface, OptionsAwareInterface
{
    use OptionsAwareTrait;
    use VariableAwareTrait;

    private ?string $url = null;

    private ?Bound $bound = null;

    /**
     * @param string  $url
     * @param mixed[] $options
     */
    public function __construct($url, Bound $bound, array $options = [])
    {
        $this->setUrl($url);
        $this->setBound($bound);
        $this->addOptions($options);
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

    public function getBound(): Bound
    {
        return $this->bound;
    }

    public function setBound(Bound $bound): void
    {
        $this->bound = $bound;
    }
}
