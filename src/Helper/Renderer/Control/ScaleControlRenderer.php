<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Helper\Renderer\Control;

use InvalidArgumentException;
use Ivory\GoogleMap\Control\ScaleControl;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractJsonRenderer;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ScaleControlRenderer extends AbstractJsonRenderer implements ControlRendererInterface
{
    /**
     * @var ControlPositionRenderer
     */
    private $controlPositionRenderer;

    /**
     * @var ScaleControlStyleRenderer
     */
    private $scaleControlStyleRenderer;

    /**
     * @param Formatter                 $formatter
     * @param JsonBuilder               $serializer
     * @param ControlPositionRenderer   $controlPositionRenderer
     * @param ScaleControlStyleRenderer $scaleControlStyleRenderer
     */
    public function __construct(
        Formatter $formatter,
        Serializer $serializer,
        ControlPositionRenderer $controlPositionRenderer,
        ScaleControlStyleRenderer $scaleControlStyleRenderer
    ) {
        parent::__construct($formatter, $serializer);

        $this->setControlPositionRenderer($controlPositionRenderer);
        $this->setScaleControlStyleRenderer($scaleControlStyleRenderer);
    }

    /**
     * @return ControlPositionRenderer
     */
    public function getControlPositionRenderer()
    {
        return $this->controlPositionRenderer;
    }

    /**
     * @param ControlPositionRenderer $controlPositionRenderer
     */
    public function setControlPositionRenderer(ControlPositionRenderer $controlPositionRenderer)
    {
        $this->controlPositionRenderer = $controlPositionRenderer;
    }

    /**
     * @return ScaleControlStyleRenderer
     */
    public function getScaleControlStyleRenderer()
    {
        return $this->scaleControlStyleRenderer;
    }

    /**
     * @param ScaleControlStyleRenderer $scaleControlStyleRenderer
     */
    public function setScaleControlStyleRenderer(ScaleControlStyleRenderer $scaleControlStyleRenderer)
    {
        $this->scaleControlStyleRenderer = $scaleControlStyleRenderer;
    }

    /**
     * @param ScaleControl $control
     *
     * @return string
     */
    public function render($control)
    {
        if (!$control instanceof ScaleControl) {
            throw new InvalidArgumentException(sprintf(
                'Expected a "%s", got "%s".',
                ScaleControl::class,
                is_object($control) ? get_class($control) : gettype($control)
            ));
        }

        return $this->getSerializer()
            ->setValue('[position]', $this->controlPositionRenderer->render($control->getPosition()), false)
            ->setValue('[style]', $this->scaleControlStyleRenderer->render($control->getStyle()), false)
            ->build();
    }
}
