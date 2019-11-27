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

use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\AbstractJsonRenderer;
use Ivory\GoogleMap\Helper\Renderer\Geometry\EncodingRenderer;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\EncodedPolyline;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class EncodedPolylineRenderer extends AbstractJsonRenderer
{
    /** @var EncodingRenderer */
    private $encodingRenderer;

    /**
     * @param Formatter        $formatter
     * @param Serializer       $serializer
     * @param EncodingRenderer $encodingRenderer
     */
    public function __construct(Formatter $formatter, Serializer $serializer, EncodingRenderer $encodingRenderer)
    {
        parent::__construct($formatter, $serializer);

        $this->setEncodingRenderer($encodingRenderer);
    }

    /**
     * @return EncodingRenderer
     */
    public function getEncodingRenderer()
    {
        return $this->encodingRenderer;
    }

    /**
     * @param EncodingRenderer $encodingRenderer
     */
    public function setEncodingRenderer(EncodingRenderer $encodingRenderer)
    {
        $this->encodingRenderer = $encodingRenderer;
    }

    /**
     * @param EncodedPolyline $encodedPolyline
     * @param Map             $map
     *
     * @return string
     */
    public function render(EncodedPolyline $encodedPolyline, Map $map)
    {
        $formatter = $this->getFormatter();

        $data         = [];
        $data['map']  = $map->getVariable();
        $data['path'] = $this->encodingRenderer->renderDecodePath($encodedPolyline->getValue());
        $data[]       = $encodedPolyline->getOptions();

        return $formatter->renderObjectAssignment($encodedPolyline, $formatter->renderObject('Polyline', [$this->getSerializer()->serialize($data, 'json')]));
    }
}
