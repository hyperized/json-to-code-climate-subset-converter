<?php

namespace BeechIt\JsonToCodeClimateSubsetConverter\Tests\Phan;

use BeechIt\JsonToCodeClimateSubsetConverter\Tests\TestCase;
use BeechIt\JsonToCodeClimateSubsetConverter\Phan\PhanJsonValidator;
use BeechIt\JsonToCodeClimateSubsetConverter\Phan\PhanConvertToSubset;

class PhanConverterTest extends TestCase
{
    public function test_it_can_convert_phan_json_to_subset(): void
    {
        // Given
        $jsonInput = file_get_contents(__DIR__ . '/fixtures/input.json');
        $jsonDecodedInput = json_decode($jsonInput);

        // When
        $validator = new PhanJsonValidator($jsonDecodedInput);
        $converter = new PhanConvertToSubset($validator, $jsonDecodedInput);
        $converter->convertToSubset();

        // Then
        $this->assertEquals(
            [
                [
                    'description' => '(Phan) UndefError PhanUndeclaredClassConstant Reference to constant class from undeclared class \PhpParser\Node\Stmt\ClassMethod',
                    'fingerprint' => 'e8547906ee21b4f8e8804de980a9d239',
                    'location' => [
                        'path' => 'app/Class.php',
                        'lines' => [
                            'begin' => 32,
                            'end' => 34,
                        ],
                    ],
                ]
            ],
            $converter->getOutput()
        );
    }

    public function test_it_can_convert_phan_json_to_json_subset(): void
    {
        // Given
        $jsonInput = file_get_contents(__DIR__ . '/fixtures/input.json');
        $jsonDecodedInput = json_decode($jsonInput);

        $jsonOutput = file_get_contents(__DIR__ . '/fixtures/output.json');

        // When
        $validator = new PhanJsonValidator($jsonDecodedInput);
        $converter = new PhanConvertToSubset($validator, $jsonDecodedInput);
        $converter->convertToSubset();

        // Then
        $this->assertEquals(
            $jsonOutput,
            $converter->getJsonEncodedOutput()
        );
    }
}
