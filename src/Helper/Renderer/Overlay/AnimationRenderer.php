<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Renderer\Overlay;

use Ivory\GoogleMap\Helper\Renderer\AbstractRenderer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class AnimationRenderer extends AbstractRenderer
{
    /**
     * @param string $animation
     */
    public function render($animation): string
    {
        return $this->getFormatter()->renderConstant('Animation', $animation);
    }
}
