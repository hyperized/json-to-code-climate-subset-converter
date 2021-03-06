<?php

namespace BeechIt\JsonToCodeClimateSubsetConverter\Tests\PHPLint;

use BeechIt\JsonToCodeClimateSubsetConverter\PHPLint\PhpLintJsonValidator;
use BeechIt\JsonToCodeClimateSubsetConverter\Tests\TestCase;
use BeechIt\JsonToCodeClimateSubsetConverter\PHPLint\PhpLintConvertToSubset;

class PhpLintConverterTest extends TestCase
{
    public function test_it_can_convert_php_lint_json_to_subset(): void
    {
        // Given
        $jsonInput = file_get_contents(__DIR__ . '/fixtures/input.json');
        $jsonDecodedInput = json_decode($jsonInput);

        // When
        $validator = new PhpLintJsonValidator($jsonDecodedInput);
        $converter = new PhpLintConvertToSubset($validator, $jsonDecodedInput);
        $converter->convertToSubset();

        // Then
        $this->assertEquals(
            [
                [
                    'description' => "(PHPLint) unexpected 'public' (T_PUBLIC), expecting ',' or ';' in line 2",
                    'fingerprint' => '9c0b73852026abfb670dd243d3b3c8f1',
                    'location' => [
                        'path' => 'app/Class.php',
                        'lines' => [
                            'begin' => 2,
                        ],
                    ],
                ]
            ],
            $converter->getOutput()
        );
    }

    public function test_it_can_convert_php_lint_json_to_json_subset(): void
    {
        // Given
        $jsonInput = file_get_contents(__DIR__ . '/fixtures/input.json');
        $jsonDecodedInput = json_decode($jsonInput);

        $jsonOutput = file_get_contents(__DIR__ . '/fixtures/output.json');

        // When
        $validator = new PhpLintJsonValidator($jsonDecodedInput);
        $converter = new PhpLintConvertToSubset($validator, $jsonDecodedInput);
        $converter->convertToSubset();

        // Then
        $this->assertEquals(
            $jsonOutput,
            $converter->getJsonEncodedOutput()
        );
    }
}
