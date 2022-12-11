<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Utility;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
trait VariableAwareTrait
{
    private ?string $variable = null;

    public function getVariable(): string
    {
        if ($this->variable === null) {
            $prefix = strtolower(substr(strrchr((string) $this::class, '\\'), 1));
            $this->variable = $prefix.substr_replace(uniqid('', true), '', 14, 1);
        }

        return $this->variable;
    }

    public function setVariable(string $variable): void
    {
        $this->variable = $variable;
    }
}
