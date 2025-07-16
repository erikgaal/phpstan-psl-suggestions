<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslSuggestions\Tests;

use ErikGaal\PhpstanPslSuggestions\FunctionMappingService;
use ErikGaal\PhpstanPslSuggestions\PslSuggestionsExtension;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Rules\RestrictedUsage\RestrictedUsage;
use PHPUnit\Framework\TestCase;

final class PslSuggestionsExtensionTest extends TestCase
{
    private PslSuggestionsExtension $extension;

    private FunctionMappingService $mappingService;

    protected function setUp(): void
    {
        $this->mappingService = new FunctionMappingService;
        $this->extension = new PslSuggestionsExtension($this->mappingService);
    }

    public function test_can_be_instantiated(): void
    {
        $this->assertInstanceOf(PslSuggestionsExtension::class, $this->extension);
    }

    public function test_get_restricted_functions_delegates_to_mapping_service(): void
    {
        $result = $this->extension->getRestrictedFunctions();
        $expected = $this->mappingService->getRestrictedFunctions();

        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
        $this->assertContains('strlen', $result);
        $this->assertContains('array_map', $result);
    }

    public function test_is_restricted_function_usage_returns_restricted_usage_for_mapped_function(): void
    {
        $functionReflection = $this->createMock(FunctionReflection::class);
        $functionReflection->method('getName')->willReturn('strlen');
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->isRestrictedFunctionUsage($functionReflection, $scope);

        $this->assertInstanceOf(RestrictedUsage::class, $result);
    }

    public function test_is_restricted_function_usage_returns_null_for_unmapped_function(): void
    {
        $functionReflection = $this->createMock(FunctionReflection::class);
        $functionReflection->method('getName')->willReturn('unknown_function');
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->isRestrictedFunctionUsage($functionReflection, $scope);

        $this->assertNull($result);
    }

    public function test_get_restriction_error_returns_message_for_native_function_with_psl_equivalent(): void
    {
        $funcCall = new FuncCall(new Name('strlen'));
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->getRestrictionError($funcCall, $scope);

        $this->assertIsString($result);
        $this->assertStringContainsString('Consider using Psl\Str\length()', $result);
        $this->assertStringContainsString('instead of strlen()', $result);
        $this->assertStringContainsString('for better type safety and consistency', $result);
    }

    public function test_get_restriction_error_returns_null_for_function_without_psl_equivalent(): void
    {
        $funcCall = new FuncCall(new Name('unknown_function'));
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->getRestrictionError($funcCall, $scope);

        $this->assertNull($result);
    }

    public function test_get_restriction_error_returns_null_for_variable_function_calls(): void
    {
        $funcCall = new FuncCall(new \PhpParser\Node\Expr\Variable('functionName'));
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->getRestrictionError($funcCall, $scope);

        $this->assertNull($result);
    }

    public function test_get_restriction_error_returns_null_for_fully_qualified_function_calls(): void
    {
        $funcCall = new FuncCall(new Name\FullyQualified('strlen'));
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->getRestrictionError($funcCall, $scope);

        $this->assertNull($result);
    }

    public function test_get_restriction_error_returns_null_for_relative_function_calls(): void
    {
        $funcCall = new FuncCall(new Name\Relative('strlen'));
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->getRestrictionError($funcCall, $scope);

        $this->assertNull($result);
    }

    public function test_generate_suggestion_message_format_consistency(): void
    {
        // Test multiple functions to ensure consistent message format
        $testCases = [
            ['strlen', 'Psl\Str\length'],
            ['array_map', 'Psl\Vec\map'],
            ['json_encode', 'Psl\Json\encode'],
        ];

        foreach ($testCases as [$nativeFunction, $pslFunction]) {
            $funcCall = new FuncCall(new Name($nativeFunction));
            $scope = $this->createMock(Scope::class);

            $result = $this->extension->getRestrictionError($funcCall, $scope);

            $this->assertIsString($result);
            $this->assertStringStartsWith('Consider using', $result);
            $this->assertStringContainsString($pslFunction.'()', $result);
            $this->assertStringContainsString('instead of '.$nativeFunction.'()', $result);
            $this->assertStringEndsWith('for better type safety and consistency.', $result);
        }
    }

    public function test_message_content_accuracy(): void
    {
        $funcCall = new FuncCall(new Name('substr'));
        $scope = $this->createMock(Scope::class);

        $result = $this->extension->getRestrictionError($funcCall, $scope);

        $this->assertEquals(
            'Consider using Psl\Str\slice() instead of substr() for better type safety and consistency.',
            $result
        );
    }

    public function test_handles_various_function_call_scenarios(): void
    {
        $scope = $this->createMock(Scope::class);

        // Test string functions
        $strlenCall = new FuncCall(new Name('strlen'));
        $this->assertStringContainsString('Psl\Str\length', $this->extension->getRestrictionError($strlenCall, $scope));

        // Test array functions
        $arrayMapCall = new FuncCall(new Name('array_map'));
        $this->assertStringContainsString('Psl\Vec\map', $this->extension->getRestrictionError($arrayMapCall, $scope));

        // Test math functions
        $absCall = new FuncCall(new Name('abs'));
        $this->assertStringContainsString('Psl\Math\abs', $this->extension->getRestrictionError($absCall, $scope));

        // Test encoding functions
        $jsonEncodeCall = new FuncCall(new Name('json_encode'));
        $this->assertStringContainsString('Psl\Json\encode', $this->extension->getRestrictionError($jsonEncodeCall, $scope));
    }

    public function test_edge_case_namespaced_functions_do_not_trigger_warnings(): void
    {
        $scope = $this->createMock(Scope::class);

        // Test that namespaced function calls don't trigger warnings
        $namespacedCall = new FuncCall(new Name('MyNamespace\strlen'));
        $this->assertNull($this->extension->getRestrictionError($namespacedCall, $scope));

        // Test that fully qualified calls don't trigger warnings
        $fullyQualifiedCall = new FuncCall(new Name\FullyQualified('strlen'));
        $this->assertNull($this->extension->getRestrictionError($fullyQualifiedCall, $scope));
    }

    public function test_edge_case_user_defined_functions_do_not_trigger_false_positives(): void
    {
        $scope = $this->createMock(Scope::class);

        // Test that functions with same names as native functions but in different contexts don't trigger warnings
        $customMappingService = new FunctionMappingService(['custom_strlen' => 'Custom\Str\length']);
        $customExtension = new PslSuggestionsExtension($customMappingService);

        // This should not trigger a warning because 'strlen' is not in our custom mapping
        $strlenCall = new FuncCall(new Name('strlen'));
        $this->assertNull($customExtension->getRestrictionError($strlenCall, $scope));

        // But this should trigger a warning because 'custom_strlen' is in our mapping
        $customStrlenCall = new FuncCall(new Name('custom_strlen'));
        $this->assertStringContainsString('Custom\Str\length', $customExtension->getRestrictionError($customStrlenCall, $scope));
    }
}
