<?php

declare(strict_types=1);

use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$rules = [
    '@PSR12' => true,
    '@Symfony' => true,
    '@Symfony:risky' => true,
    '@PHP83Migration' => true,
    '@DoctrineAnnotation' => true,

    // Alias
    'mb_str_functions' => true, // not present in any ruleset
    'no_alias_functions' => ['sets' => ['@all']], // overrides @Symfony:risky
    'random_api_migration' => ['replacements' => ['getrandmax' => 'mt_getrandmax', 'rand' => 'mt_rand', 'srand' => 'mt_srand']], // not present in used rulesets

    // Class notation
    'class_attributes_separation' => ['elements' => ['const' => 'one', 'method' => 'one', 'property' => 'one', 'trait_import' => 'none']], // overrides @Symfony
    'class_definition' => ['single_line' => true, 'single_item_single_line' => true, 'multi_line_extends_each_single_line' => true], // overrides @PSR12 and @Symfony
    'ordered_class_elements' => [  // overrides @PSR12
        'order' => [
            'use_trait',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public_static',
            'property_protected_static',
            'property_private_static',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'magic',
            'method_public_abstract',
            'method_protected_abstract',
            'method_public_abstract_static',
            'method_protected_abstract_static',
            'method_public_static',
            'method_protected_static',
            'method_private_static',
            'method_public',
            'method_protected',
            'method_private',
        ],
    ],
    'ordered_interfaces' => ['order' => 'alpha', 'direction' => 'ascend'], // no ruleset
    'protected_to_private' => true, // not present in used rulesets
    'self_static_accessor' => true, // not present in used rulesets

    // Comment
    'comment_to_phpdoc' => ['ignored_tags' => []], // not present in used rulesets
    'header_comment' => false, // not present in any ruleset, does nothing
    'multiline_comment_opening_closing' => true, // not present in used rulesets
    'single_line_comment_style' => ['comment_types' => ['asterisk', 'hash']], // overrides @Symfony

    // Constant notation
    'native_constant_invocation' => ['fix_built_in' => true, 'include' => [], 'exclude' => ['null', 'false', 'true'], 'scope' => 'all', 'strict' => false], // overrides @Symfony:risky

    // Control structure
    'no_break_comment' => false, // overrides @PSR12
    'no_superfluous_elseif' => false, // not present in used rulesets
    'no_unneeded_control_parentheses' => ['statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield']], // overrides @Symfony
    'no_useless_else' => true, // not present in used rulesets
    'simplified_if_return' => true, // not present in used rulesets
    'yoda_style' => ['equal' => true, 'identical' => true, 'less_and_greater' => true, 'always_move_variable' => true], // overrides @Symfony

    // Doctrine annotation
    'doctrine_annotation_array_assignment' => ['operator' => '='], // overrides @DoctrineAnnotations
    'doctrine_annotation_braces' => ['syntax' => 'without_braces'], // @DoctrineAnnotations
    'doctrine_annotation_indentation' => ['indent_mixed_lines' => true], // overrides @DoctrineAnnotations
    'doctrine_annotation_spaces' => [ // overrides @DoctrineAnnotations
        'around_parentheses' => true,
        'around_commas' => true,
        'before_argument_assignments' => false,
        'after_argument_assignments' => false,
        'before_array_assignments_equals' => true,
        'after_array_assignments_equals' => true,
        'before_array_assignments_colon' => true,
        'after_array_assignments_colon' => true,
    ],

    // Function notation
    'fopen_flags' => ['b_mode' => true], // overrides @Symfony:risky
    'function_declaration' => ['closure_function_spacing' => 'none'], // overrides @PSR12 and @Symfony
    'method_argument_space' => ['keep_multiple_spaces_after_comma' => false, 'on_multiline' => 'ensure_fully_multiline', 'after_heredoc' => true], // overrides @PSR12 and @Symfony
    'native_function_invocation' => ['include' => ['@internal'], 'scope' => 'all', 'strict' => false], // overrides @Symfony:risky
    'no_unreachable_default_argument_value' => true, // overrides @Symfony:risky
    'regular_callable_call' => true, // not present in any ruleset
    'single_line_throw' => false, // overrides @Symfony
    'static_lambda' => true, // not present in used rulesets
    'use_arrow_functions' => true, // not present in used rulesets
    'void_return' => true, // not present in used rulesets

    // Import
    'group_import' => false, // not present in any ruleset, does nothing

    // Language construct
    'combine_consecutive_issets' => true, // not present in used rulesets
    'combine_consecutive_unsets' => true, // not present in used rulesets
    'error_suppression' => ['noise_remaining_usages' => true], // overrides @Symfony:risky
    'explicit_indirect_variable' => true, // not present in used rulesets
    'no_unset_on_property' => true, // not present in used rulesets

    // Operator
    'not_operator_with_space' => false, // not present in any ruleset, does nothing
    'not_operator_with_successor_space' => false, // not present in any ruleset, does nothing
    'operator_linebreak' => ['only_booleans' => false, 'position' => 'beginning'], // overrides @Symfony
    'increment_style' => false, // overrides @Symfony

    // PHPDoc
    'phpdoc_add_missing_param_annotation' => true, // not present in used rulesets
    'phpdoc_order' => true, // overrides @Symfony
    'phpdoc_separation' => true, // overrides @Symfony
    'phpdoc_var_without_name' => false, // overrides @Symfony
    'phpdoc_to_comment' => false, // overrides @Symfony
    'phpdoc_align' => false, // overrides @Symfony
    'phpdoc_tag_type' => false, // overrides @Symfony
    'phpdoc_summary' => false, // overrides @Symfony
    'phpdoc_param_order' => true, // not present in any ruleset
    'phpdoc_annotation_without_dot' => false, // overrides @Symfony
    'no_superfluous_phpdoc_tags' => false, // overrides @Symfony
    'no_blank_lines_after_phpdoc' => false, // overrides @Symfony
    'phpdoc_no_package' => false, // overrides @Symfony

    // PHPUnit
    'php_unit_test_case_static_method_calls' => ['call_type' => 'this'], // not present in used rulesets
    'php_unit_data_provider_name' => false, // not present in used rulesets

    // Return notation
    'no_useless_return' => true, // not present in used rulesets
    'return_assignment' => true, // not present in used rulesets
    'simplified_null_return' => false, // not present in any ruleset, does nothing

    // Semicolon
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'], // not present in used rulesets

    // Strict
    'declare_strict_types' => true, // not present in used rulesets
    'strict_comparison' => true, // not present in used rulesets
    'strict_param' => true, // not present in used rulesets

    // String notation
    'string_implicit_backslashes' => ['single_quoted' => 'ignore', 'double_quoted' => 'escape', 'heredoc' => 'escape'], // not present in used rulesets
    'explicit_string_variable' => true, // not present in used rulesets
    'heredoc_to_nowdoc' => true, // not present in used rulesets
    'single_quote' => ['strings_containing_single_quote_chars' => true], // overrides @Symfony

    // Whitespace
    'array_indentation' => true, // not present in used rulesets
    'blank_line_before_statement' => [ // overrides @Symfony
        'statements' => [
            'break',
            'continue',
            'declare',
            'default',
            'do',
            'exit',
            'for',
            'foreach',
            'goto',
            'if',
            'include',
            'include_once',
            'require',
            'require_once',
            'return',
            'switch',
            'throw',
            'try',
            'while',
            'yield',
            'yield_from',
        ],
    ],
    'method_chaining_indentation' => true, // not present in used rulesets
    'no_extra_blank_lines' => [ // overrides @Symfony
        'tokens' => [
            'break',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
        ],
    ],
    'statement_indentation' => true, // @PSR12, overrides @Symfony

];

$excludes = [
    'vendor',
    'var',
    'tests/_support/_generated',
    'config',
];

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude($excludes)
            ->notName('README.md')
            ->notName('*.xml')
            ->notName('*.yml')
            ->notName('_ide_helper.php')
    );
