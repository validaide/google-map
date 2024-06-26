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

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractRenderer
{
    private ?Formatter $formatter = null;

    public function __construct(Formatter $formatter)
    {
        $this->setFormatter($formatter);
    }

    public function getFormatter(): Formatter
    {
        return $this->formatter;
    }

    /**
     * @param Formatter $formatter
     */
    public function setFormatter($formatter)
    {
        $this->formatter = $formatter;
    }
}
