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
use Ivory\GoogleMap\Control\ZoomControl;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractJsonRenderer;
use Ivory\JsonBuilder\JsonBuilder;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ZoomControlRenderer extends AbstractJsonRenderer implements ControlRendererInterface
{
    /**
     * @var ControlPositionRenderer
     */
    private $controlPositionRenderer;

    /**
     * @var ZoomControlStyleRenderer
     */
    private $zoomControlStyleRenderer;

    /**
     * @param Formatter                $formatter
     * @param JsonBuilder              $serializer
     * @param ControlPositionRenderer  $controlPositionRenderer
     * @param ZoomControlStyleRenderer $zoomControlStyleRenderer
     */
    public function __construct(
        Formatter $formatter,
        JsonBuilder $serializer,
        ControlPositionRenderer $controlPositionRenderer,
        ZoomControlStyleRenderer $zoomControlStyleRenderer
    ) {
        parent::__construct($formatter, $serializer);

        $this->setControlPositionRenderer($controlPositionRenderer);
        $this->setZoomControlStyleRenderer($zoomControlStyleRenderer);
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
     * @return ZoomControlStyleRenderer
     */
    public function getZoomControlStyleRenderer()
    {
        return $this->zoomControlStyleRenderer;
    }

    /**
     * @param ZoomControlStyleRenderer $zoomControlStyleRenderer
     */
    public function setZoomControlStyleRenderer(ZoomControlStyleRenderer $zoomControlStyleRenderer)
    {
        $this->zoomControlStyleRenderer = $zoomControlStyleRenderer;
    }

    /**
     * {@inheritdoc}
     */
    public function render($control)
    {
        if (!$control instanceof ZoomControl) {
            throw new InvalidArgumentException(sprintf(
                'Expected a "%s", got "%s".',
                ZoomControl::class,
                is_object($control) ? get_class($control) : gettype($control)
            ));
        }

        return $this->getSerializer()
            ->setValue('[position]', $this->controlPositionRenderer->render($control->getPosition()), false)
            ->setValue('[style]', $this->zoomControlStyleRenderer->render($control->getStyle()), false)
            ->build();
    }
}
