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

use Ivory\GoogleMap\Helper\ApiHelper;
use Ivory\GoogleMap\Helper\Collector\Layer\HeatmapLayerCollector;
use Ivory\GoogleMap\Helper\Collector\Overlay\EncodedPolylineCollector;
use Ivory\GoogleMap\Helper\Collector\Overlay\InfoBoxCollector;
use Ivory\GoogleMap\Helper\Collector\Overlay\MarkerCollector;
use Ivory\GoogleMap\Helper\Formatter\Formatter;
use Ivory\GoogleMap\Helper\Renderer\ApiInitRenderer;
use Ivory\GoogleMap\Helper\Renderer\ApiRenderer;
use Ivory\GoogleMap\Helper\Renderer\Control\ControlManagerRenderer;
use Ivory\GoogleMap\Helper\Renderer\Geometry\EncodingRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\JavascriptTagRenderer;
use Ivory\GoogleMap\Helper\Renderer\Html\TagRenderer;
use Ivory\GoogleMap\Helper\Renderer\Layer\HeatmapLayerRenderer;
use Ivory\GoogleMap\Helper\Renderer\LoaderRenderer;
use Ivory\GoogleMap\Helper\Renderer\MapRenderer;
use Ivory\GoogleMap\Helper\Renderer\MapTypeIdRenderer;
use Ivory\GoogleMap\Helper\Renderer\Overlay\EncodedPolylineRenderer;
use Ivory\GoogleMap\Helper\Renderer\Overlay\InfoBoxRenderer;
use Ivory\GoogleMap\Helper\Renderer\Overlay\MarkerClustererRenderer;
use Ivory\GoogleMap\Helper\Renderer\Place\AutocompleteRenderer;
use Ivory\GoogleMap\Helper\Renderer\Utility\CallbackRenderer;
use Ivory\GoogleMap\Helper\Renderer\Utility\RequirementLoaderRenderer;
use Ivory\GoogleMap\Helper\Renderer\Utility\RequirementRenderer;
use Ivory\GoogleMap\Helper\Renderer\Utility\SourceRenderer;
use Ivory\GoogleMap\Helper\Subscriber\ApiJavascriptSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Layer\HeatmapLayerSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\MapJavascriptSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Overlay\EncodedPolylineSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Overlay\InfoBoxSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Overlay\MarkerClustererSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Place\AutocompleteJavascriptSubscriber;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ApiHelperBuilder extends AbstractJavascriptHelperBuilder
{
    private ?string $language = null;
    private ?string $key      = null;

    public function __construct(
        Formatter   $formatter = null,
        JsonBuilder $jsonBuilder = null,
        string      $language = 'en'
    )
    {
        parent::__construct($formatter, $jsonBuilder);

        $this->setLanguage($language);
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function hasKey(): bool
    {
        return $this->key !== null;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function build(): ApiHelper
    {
        return new ApiHelper($this->createEventDispatcher());
    }

    protected function createSubscribers(): array
    {
        $formatter   = $this->getFormatter();
        $jsonBuilder = $this->getJsonBuilder();

        // Layer collectors
        $heatmapLayerCollector = new HeatmapLayerCollector();

        // Overlay collectors
        $encodedPolylineCollector = new EncodedPolylineCollector();
        $markerCollector          = new MarkerCollector();
        $infoBoxCollector         = new InfoBoxCollector($markerCollector);

        // Control renderers
        $controlManagerRenderer = new ControlManagerRenderer();

        // Layer renderers
        $heatmapLayerRenderer = new HeatmapLayerRenderer($formatter, $jsonBuilder);

        // Utility renderers
        $callbackRenderer          = new CallbackRenderer($formatter);
        $loaderRenderer            = new LoaderRenderer($formatter, $jsonBuilder, $this->language, $this->key);
        $requirementLoaderRenderer = new RequirementLoaderRenderer($formatter);
        $requirementRenderer       = new RequirementRenderer($formatter);
        $sourceRenderer            = new SourceRenderer($formatter);

        // Map renderers
        $mapTypeIdRenderer = new MapTypeIdRenderer($formatter);
        $mapRenderer       = new MapRenderer(
            $formatter,
            $jsonBuilder,
            $mapTypeIdRenderer,
            $controlManagerRenderer,
            $requirementRenderer
        );

        // Overlay renderers
        $encodingRenderer        = new EncodingRenderer($formatter);
        $encodedPolylineRenderer = new EncodedPolylineRenderer($formatter, $jsonBuilder, $encodingRenderer);
        $infoBoxRenderer         = new InfoBoxRenderer($formatter, $jsonBuilder, $requirementRenderer);
        $markerClustererRenderer = new MarkerClustererRenderer($formatter, $jsonBuilder, $requirementRenderer);

        // Place renderers
        $autocompleteRenderer = new AutocompleteRenderer($formatter, $jsonBuilder, $requirementRenderer);

        // Html renderers
        $tagRenderer           = new TagRenderer($formatter);
        $javascriptTagRenderer = new JavascriptTagRenderer($formatter, $tagRenderer);

        // Api renderers
        $apiInitRenderer = new ApiInitRenderer($formatter);
        $apiRenderer     = new ApiRenderer(
            $formatter,
            $apiInitRenderer,
            $loaderRenderer,
            $requirementLoaderRenderer,
            $sourceRenderer
        );

        return array_merge([
            new ApiJavascriptSubscriber($formatter, $apiRenderer, $javascriptTagRenderer),
            new AutocompleteJavascriptSubscriber(
                $formatter,
                $autocompleteRenderer,
                $callbackRenderer,
                $javascriptTagRenderer
            ),
            new EncodedPolylineSubscriber($formatter, $encodedPolylineCollector, $encodedPolylineRenderer),
            new HeatmapLayerSubscriber($formatter, $heatmapLayerCollector, $heatmapLayerRenderer),
            new InfoBoxSubscriber($formatter, $infoBoxCollector, $infoBoxRenderer),
            new MapJavascriptSubscriber($formatter, $mapRenderer, $callbackRenderer, $javascriptTagRenderer),
            new MarkerClustererSubscriber($formatter, $markerClustererRenderer),
        ], parent::createSubscribers());
    }
}