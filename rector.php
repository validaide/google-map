<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonySetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses();
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    $rectorConfig->sets([
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        LevelSetList::UP_TO_PHP_81,
        Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_80,
        SymfonySetList::SYMFONY_64,
    ]);

    $rectorConfig->paths([
        __DIR__ . '/src',     // or wherever your project files are
        __DIR__ . '/tests',
    ]);

    $rectorConfig->rules([
        RenameClassRector::class,
    ]);

    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
        'Http\Adapter\Guzzle6\Client' => 'Http\Adapter\Guzzle7\Client',
    ]);
};
