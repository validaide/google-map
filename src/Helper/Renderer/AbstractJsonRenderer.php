<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Renderer;

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractJsonRenderer extends AbstractRenderer
{
    /** @var Serializer */
    private $serializer;

    /**
     * @param Formatter  $formatter
     * @param Serializer $serializer
     */
    public function __construct(Formatter $formatter, Serializer $serializer)
    {
        parent::__construct($formatter);

        $this->setSerializer($serializer);
    }

    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    /**
     * @param Serializer $serializer
     */
    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }
}
