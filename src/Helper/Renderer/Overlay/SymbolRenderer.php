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
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Helper\Builder\JsonBuilder;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class SymbolRenderer extends AbstractJsonRenderer
{
    private ?SymbolPathRenderer $symbolPathRenderer = null;

    public function __construct(Formatter $formatter, JsonBuilder $jsonBuilder, SymbolPathRenderer $symbolPathRenderer)
    {
        parent::__construct($formatter, $jsonBuilder);

        $this->setSymbolPathRenderer($symbolPathRenderer);
    }

    public function getSymbolPathRenderer(): SymbolPathRenderer
    {
        return $this->symbolPathRenderer;
    }

    public function setSymbolPathRenderer(SymbolPathRenderer $symbolPathRenderer): void
    {
        $this->symbolPathRenderer = $symbolPathRenderer;
    }

    public function render(Symbol $symbol): string
    {
        $jsonBuilder = $this->getJsonBuilder()
            ->setValue('[path]', $this->symbolPathRenderer->render($symbol->getPath()), false);

        if ($symbol->hasAnchor()) {
            $jsonBuilder->setValue('[anchor]', $symbol->getAnchor()->getVariable(), false);
        }

        if ($symbol->hasLabelOrigin()) {
            $jsonBuilder->setValue('[labelOrigin]', $symbol->getLabelOrigin()->getVariable(), false);
        }

        $jsonBuilder->setValues($symbol->getOptions());

        return $this->getFormatter()->renderObjectAssignment($symbol, $jsonBuilder->build());
    }
}
