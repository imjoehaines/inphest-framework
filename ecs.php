<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/bin',
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/meta-tests',
    ]);

    $parameters->set(Option::SETS, [
        SetList::PSR_12,
        SetList::CLEAN_CODE,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::DEAD_CODE,
    ]);
};
