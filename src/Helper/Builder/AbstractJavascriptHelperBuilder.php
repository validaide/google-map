<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Builder;

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractJavascriptHelperBuilder extends AbstractHelperBuilder
{
    /** @var Formatter */
    private $formatter;
    /** @var Serializer */
    private $serializer;

    /**
     * @param Formatter  $formatter
     * @param Serializer $serializer
     */
    public function __construct(Formatter $formatter, Serializer $serializer)
    {
        $this->setFormatter($formatter);
        $this->setSerializer($serializer);
    }

    /**
     * @return static
     */
    public static function create()
    {
        return new static(new Formatter(), new Serializer([new JsonSerializableNormalizer()], [new JsonEncoder()]));
    }

    /**
     * @return Formatter
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * @param Formatter $formatter
     *
     * @return $this
     */
    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @param Serializer $serializer
     *
     * @return $this
     */
    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }
}
