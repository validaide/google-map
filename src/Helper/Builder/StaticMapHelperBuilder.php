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

use Ivory\GoogleMap\Helper\Collector\Image\EncodedPolylineCollector;
use Ivory\GoogleMap\Helper\Collector\Image\ExtendableCollector;
use Ivory\GoogleMap\Helper\Collector\Image\MarkerCollector;
use Ivory\GoogleMap\Helper\Collector\Image\PolylineCollector;
use Ivory\GoogleMap\Helper\Renderer\Image\Base\CoordinateRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Base\PointRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\EncodedPolylineRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\EncodedPolylineStyleRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\EncodedPolylineValueRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\ExtendableRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\MarkerLocationRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\MarkerRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\MarkerStyleRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\PolylineLocationRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\PolylineRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\Overlay\PolylineStyleRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\SizeRenderer;
use Ivory\GoogleMap\Helper\Renderer\Image\StyleRenderer;
use Ivory\GoogleMap\Helper\StaticMapHelper;
use Ivory\GoogleMap\Helper\Subscriber\Image\CenterSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\EncodedPolylineSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\ExtendableSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\FormatSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\KeySubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\MarkerSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\PolylineSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\ScaleSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\SizeSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\StaticSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\StyleSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\TypeSubscriber;
use Ivory\GoogleMap\Helper\Subscriber\Image\ZoomSubscriber;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class StaticMapHelperBuilder extends AbstractHelperBuilder
{
    private ?string $key = null;

    private ?string $secret = null;

    private ?string $clientId = null;

    private ?string $channel = null;

    public function __construct(string|null $key = null, string|null $secret = null, string|null $clientId = null, string|null $channel = null)
    {
        $this->setKey($key);
        $this->setSecret($secret);
        $this->setClientId($clientId);
        $this->setChannel($channel);
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

    public function hasSecret(): bool
    {
        return $this->secret !== null;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function setSecret(?string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function hasClientId(): bool
    {
        return $this->clientId !== null;
    }

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    public function setClientId(?string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function hasChannel(): bool
    {
        return $this->channel !== null;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function build(): StaticMapHelper
    {
        return new StaticMapHelper(
            $this->createEventDispatcher(),
            $this->getSecret(),
            $this->getClientId(),
            $this->getChannel()
        );
    }

    protected function createSubscribers(): array
    {
        // Pre-loaded Renderers
        $pointRenderer = new PointRenderer();
        $markerStyleRenderer = new MarkerStyleRenderer($pointRenderer);

        // Collectors
        $encodedPolylineCollector = new EncodedPolylineCollector();
        $extendableCollector = new ExtendableCollector();
        $markerCollector = new MarkerCollector($markerStyleRenderer);
        $polylineCollector = new PolylineCollector();

        // Renderers
        $coordinateRenderer = new CoordinateRenderer();
        $sizeRenderer = new SizeRenderer();
        $styleRenderer = new StyleRenderer();
        $encodedPolylineValueRenderer = new EncodedPolylineValueRenderer();
        $encodedPolylineStyleRenderer = new EncodedPolylineStyleRenderer();
        $encodedPolylineRenderer = new EncodedPolylineRenderer($encodedPolylineStyleRenderer, $encodedPolylineValueRenderer);
        $markerLocationRenderer = new MarkerLocationRenderer($coordinateRenderer);
        $markerRenderer = new MarkerRenderer($markerStyleRenderer, $markerLocationRenderer);
        $polylineLocationRenderer = new PolylineLocationRenderer($coordinateRenderer);
        $polylineStyleRenderer = new PolylineStyleRenderer();
        $polylineRenderer = new PolylineRenderer($polylineStyleRenderer, $polylineLocationRenderer);
        $extendableRenderer = new ExtendableRenderer(
            $coordinateRenderer,
            $markerLocationRenderer,
            $polylineLocationRenderer
        );

        return array_merge([
            new CenterSubscriber($coordinateRenderer),
            new EncodedPolylineSubscriber($encodedPolylineCollector, $encodedPolylineRenderer),
            new ExtendableSubscriber($extendableCollector, $extendableRenderer),
            new FormatSubscriber(),
            new KeySubscriber($this->key),
            new MarkerSubscriber($markerCollector, $markerRenderer),
            new PolylineSubscriber($polylineCollector, $polylineRenderer),
            new ScaleSubscriber(),
            new SizeSubscriber($sizeRenderer),
            new StyleSubscriber($styleRenderer),
            new StaticSubscriber(),
            new TypeSubscriber(),
            new ZoomSubscriber(),
        ], parent::createSubscribers());
    }
}