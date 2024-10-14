<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use PHPyh\CodingStandard\PhpCsFixerCodingStandard;

$finder = (new Finder())
    ->in([
        __DIR__ . '/commands',
        __DIR__ . '/config',
        __DIR__ . '/controllers',
        __DIR__ . '/views',
        __DIR__ . '/web',
    ])
    ->append([
        __FILE__,
        __DIR__ . '/composer-unused.php',
        __DIR__ . '/rector.php',
        __DIR__ . '/yii',
    ])
    ->exclude('var')
;

$config = (new Config())
    ->setCacheFile(__DIR__ . '/var/.php-cs-fixer.cache')
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setFinder($finder)
;

(new PhpCsFixerCodingStandard())->applyTo($config, [
    'method_chaining_indentation' => true,
    'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
    'single_line_empty_body' => false,
]);

return $config;
