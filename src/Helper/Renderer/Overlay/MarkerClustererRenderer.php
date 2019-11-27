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
use Ivory\GoogleMap\Helper\Renderer\Utility\RequirementRenderer;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\MarkerCluster;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MarkerClustererRenderer extends AbstractJsonRenderer
{
    /** @var RequirementRenderer */
    private $requirementRenderer;

    /**
     * @param Formatter           $formatter
     * @param Serializer          $serializer
     * @param RequirementRenderer $requirementRenderer
     */
    public function __construct(Formatter $formatter, Serializer $serializer, RequirementRenderer $requirementRenderer)
    {
        parent::__construct($formatter, $serializer);

        $this->setRequirementRenderer($requirementRenderer);
    }

    /**
     * @return RequirementRenderer
     */
    public function getRequirementRenderer()
    {
        return $this->requirementRenderer;
    }

    /**
     * @param RequirementRenderer $requirementRenderer
     */
    public function setRequirementRenderer(RequirementRenderer $requirementRenderer)
    {
        $this->requirementRenderer = $requirementRenderer;
    }

    /**
     * @param MarkerCluster $markerCluster
     * @param Map           $map
     * @param string        $markers
     *
     * @return string
     */
    public function render(MarkerCluster $markerCluster, Map $map, $markers)
    {
        $formatter = $this->getFormatter();
        $options   = $markerCluster->getOptions();

        if (!isset($options['imagePath'])) {
            $options['imagePath'] = 'https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/images/m';
        }

        return $formatter->renderObjectAssignment($markerCluster, $formatter->renderObject('MarkerClusterer', [
            $map->getVariable(),
            $markers,
            $this->getSerializer()->serialize($options, 'json'),
        ], false));
    }

    /**
     * @return string
     */
    public function renderSource()
    {
        return 'https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js';
    }

    /**
     * @return string
     */
    public function renderRequirement()
    {
        return $this->requirementRenderer->render('MarkerClusterer');
    }
}
