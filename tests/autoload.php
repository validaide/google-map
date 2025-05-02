<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Extensions\Selenium2TestCase;

$cacheReset = getenv('CACHE_RESET') ?: $_SERVER['CACHE_RESET'] ?? false;

if (isset($_SERVER['CACHE_PATH'])) {
    $_SERVER['CACHE_PATH'] = __DIR__ . '/../' . $_SERVER['CACHE_PATH'];

    if ($cacheReset === 'true' || $cacheReset === true) {
        exec('rm -rf ' . $_SERVER['CACHE_PATH'] . '/*');

        while (count(scandir($_SERVER['CACHE_PATH'])) > 2) {
            usleep(100_000);
        }
    }
}

require_once __DIR__ . '/../vendor/autoload.php';

Selenium2TestCase::shareSession(true);
