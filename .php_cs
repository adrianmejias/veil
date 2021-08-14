<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'function_typehint_space' => true,
        'hash_to_slash_comment' => true,
        'lowercase_cast' => true,
        'ordered_imports' => true,
        'native_function_casing' => true,
        'no_alias_functions' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_leading_namespace_whitespace' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,
        'no_empty_statement' => true,
        'no_extra_consecutive_blank_lines' => [
            'continue',
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'square_brace_block',
            'throw',
        ],
        'no_short_bool_cast' => true,
        'no_unneeded_control_parentheses' => [
            'break',
            'clone',
            'continue',
            'echo_print',
            'return',
            'switch_case',
        ],
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'self_accessor' => true,
        'single_quote' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder(
        Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    );
