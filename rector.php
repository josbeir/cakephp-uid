<?php
declare(strict_types=1);

use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\Config\RectorConfig;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPhpVersion(PhpVersion::PHP_83)
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        DisallowedEmptyRuleFixerRector::class,
        SimplifyIfElseToTernaryRector::class,
    ])
    ->withImportNames(
        importNames: true,
        importDocBlockNames: false,
        importShortClasses: false,
        removeUnusedImports: true,
    )
    ->withParallel()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        //naming: true,
        typeDeclarations: true,
    );
