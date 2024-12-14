<?php

use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/tests')
    ->in(__DIR__ . '/database')
    ->in(__DIR__ . "/config")
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12'                      => true,
        'psr_autoloading'             => true,
        'array_syntax'                => ['syntax' => 'short'],
        'no_unused_imports'           => true,
        'no_whitespace_in_blank_line' => true,
        'return_type_declaration'     => [
            'space_before' => 'none',
        ],
        'lowercase_cast'             => true,
        'short_scalar_cast'          => true,
        'combine_consecutive_issets' => true,
        'ordered_imports'            => [
            'sort_algorithm' => 'alpha',
        ],
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
        ],
    ])
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setFinder($finder);
