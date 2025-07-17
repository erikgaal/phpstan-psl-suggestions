<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslRule\Tests;

use ErikGaal\PhpstanPslRule\FunctionMappingService;
use PHPUnit\Framework\TestCase;

final class FunctionMappingServiceTest extends TestCase
{
    private FunctionMappingService $service;

    protected function setUp(): void
    {
        $this->service = new FunctionMappingService;
    }

    public function test_can_be_instantiated(): void
    {
        $this->assertInstanceOf(FunctionMappingService::class, $this->service);
    }

    public function test_can_be_instantiated_with_custom_mappings(): void
    {
        $customMappings = ['custom_func' => 'Psl\Custom\func'];
        $service = new FunctionMappingService($customMappings);

        $this->assertInstanceOf(FunctionMappingService::class, $service);
        $this->assertTrue($service->hasPslEquivalent('custom_func'));
        $this->assertEquals('Psl\Custom\func', $service->getPslEquivalent('custom_func'));
    }

    public function test_get_restricted_functions_returns_array(): void
    {
        $result = $this->service->getRestrictedFunctions();
        $this->assertIsArray($result);
    }

    public function test_get_restricted_functions_contains_expected_functions(): void
    {
        $result = $this->service->getRestrictedFunctions();

        // Test string functions
        $this->assertContains('strlen', $result);
        $this->assertContains('substr', $result);
        $this->assertContains('strpos', $result);
        $this->assertContains('str_replace', $result);
        $this->assertContains('strtolower', $result);
        $this->assertContains('strtoupper', $result);
        $this->assertContains('trim', $result);
        $this->assertContains('ltrim', $result);
        $this->assertContains('rtrim', $result);
        $this->assertContains('implode', $result);
        $this->assertContains('explode', $result);

        // Test array functions
        $this->assertContains('array_map', $result);
        $this->assertContains('array_filter', $result);
        $this->assertContains('array_reduce', $result);
        $this->assertContains('array_keys', $result);
        $this->assertContains('array_values', $result);
        $this->assertContains('array_merge', $result);
        $this->assertContains('count', $result);
        $this->assertContains('in_array', $result);

        // Test math functions
        $this->assertContains('abs', $result);
        $this->assertContains('max', $result);
        $this->assertContains('min', $result);
        $this->assertContains('round', $result);
        $this->assertContains('ceil', $result);
        $this->assertContains('floor', $result);

        // Test type functions
        $this->assertContains('is_string', $result);
        $this->assertContains('is_int', $result);
        $this->assertContains('is_array', $result);
        $this->assertContains('is_bool', $result);

        // Test file functions
        $this->assertContains('file_get_contents', $result);
        $this->assertContains('file_put_contents', $result);

        // Test encoding functions
        $this->assertContains('base64_encode', $result);
        $this->assertContains('base64_decode', $result);
        $this->assertContains('json_encode', $result);
        $this->assertContains('json_decode', $result);
    }

    public function test_get_restricted_functions_returns_non_empty_array(): void
    {
        $result = $this->service->getRestrictedFunctions();
        $this->assertNotEmpty($result);
        $this->assertGreaterThan(50, count($result)); // We have many mappings
    }

    public function test_get_psl_equivalent_returns_correct_mappings(): void
    {
        // Test string functions
        $this->assertEquals('Psl\Str\length', $this->service->getPslEquivalent('strlen'));
        $this->assertEquals('Psl\Str\slice', $this->service->getPslEquivalent('substr'));
        $this->assertEquals('Psl\Str\search', $this->service->getPslEquivalent('strpos'));
        $this->assertEquals('Psl\Str\replace', $this->service->getPslEquivalent('str_replace'));
        $this->assertEquals('Psl\Str\lowercase', $this->service->getPslEquivalent('strtolower'));
        $this->assertEquals('Psl\Str\uppercase', $this->service->getPslEquivalent('strtoupper'));
        $this->assertEquals('Psl\Str\trim', $this->service->getPslEquivalent('trim'));
        $this->assertEquals('Psl\Str\join', $this->service->getPslEquivalent('implode'));
        $this->assertEquals('Psl\Str\split', $this->service->getPslEquivalent('explode'));

        // Test array functions
        $this->assertEquals('Psl\Vec\map', $this->service->getPslEquivalent('array_map'));
        $this->assertEquals('Psl\Vec\filter', $this->service->getPslEquivalent('array_filter'));
        $this->assertEquals('Psl\Vec\reduce', $this->service->getPslEquivalent('array_reduce'));
        $this->assertEquals('Psl\Dict\keys', $this->service->getPslEquivalent('array_keys'));
        $this->assertEquals('Psl\Dict\values', $this->service->getPslEquivalent('array_values'));
        $this->assertEquals('Psl\Vec\count', $this->service->getPslEquivalent('count'));
        $this->assertEquals('Psl\Vec\contains', $this->service->getPslEquivalent('in_array'));

        // Test math functions
        $this->assertEquals('Psl\Math\abs', $this->service->getPslEquivalent('abs'));
        $this->assertEquals('Psl\Math\max', $this->service->getPslEquivalent('max'));
        $this->assertEquals('Psl\Math\min', $this->service->getPslEquivalent('min'));
        $this->assertEquals('Psl\Math\round', $this->service->getPslEquivalent('round'));
        $this->assertEquals('Psl\Math\ceil', $this->service->getPslEquivalent('ceil'));
        $this->assertEquals('Psl\Math\floor', $this->service->getPslEquivalent('floor'));

        // Test type functions
        $this->assertEquals('Psl\Type\string', $this->service->getPslEquivalent('is_string'));
        $this->assertEquals('Psl\Type\int', $this->service->getPslEquivalent('is_int'));
        $this->assertEquals('Psl\Type\vec', $this->service->getPslEquivalent('is_array'));
        $this->assertEquals('Psl\Type\bool', $this->service->getPslEquivalent('is_bool'));

        // Test file functions
        $this->assertEquals('Psl\File\read', $this->service->getPslEquivalent('file_get_contents'));
        $this->assertEquals('Psl\File\write', $this->service->getPslEquivalent('file_put_contents'));

        // Test encoding functions
        $this->assertEquals('Psl\Encoding\Base64\encode', $this->service->getPslEquivalent('base64_encode'));
        $this->assertEquals('Psl\Encoding\Base64\decode', $this->service->getPslEquivalent('base64_decode'));
        $this->assertEquals('Psl\Json\encode', $this->service->getPslEquivalent('json_encode'));
        $this->assertEquals('Psl\Json\decode', $this->service->getPslEquivalent('json_decode'));
    }

    public function test_get_psl_equivalent_returns_null_for_unknown_function(): void
    {
        $result = $this->service->getPslEquivalent('unknown_function');
        $this->assertNull($result);
    }

    public function test_get_psl_equivalent_returns_null_for_empty_string(): void
    {
        $result = $this->service->getPslEquivalent('');
        $this->assertNull($result);
    }

    public function test_get_psl_equivalent_is_case_sensitive(): void
    {
        $this->assertEquals('Psl\Str\length', $this->service->getPslEquivalent('strlen'));
        $this->assertNull($this->service->getPslEquivalent('STRLEN'));
        $this->assertNull($this->service->getPslEquivalent('StrLen'));
    }

    public function test_has_psl_equivalent_returns_true_for_mapped_functions(): void
    {
        // Test string functions
        $this->assertTrue($this->service->hasPslEquivalent('strlen'));
        $this->assertTrue($this->service->hasPslEquivalent('substr'));
        $this->assertTrue($this->service->hasPslEquivalent('strpos'));
        $this->assertTrue($this->service->hasPslEquivalent('str_replace'));
        $this->assertTrue($this->service->hasPslEquivalent('trim'));
        $this->assertTrue($this->service->hasPslEquivalent('implode'));
        $this->assertTrue($this->service->hasPslEquivalent('explode'));

        // Test array functions
        $this->assertTrue($this->service->hasPslEquivalent('array_map'));
        $this->assertTrue($this->service->hasPslEquivalent('array_filter'));
        $this->assertTrue($this->service->hasPslEquivalent('count'));
        $this->assertTrue($this->service->hasPslEquivalent('in_array'));

        // Test math functions
        $this->assertTrue($this->service->hasPslEquivalent('abs'));
        $this->assertTrue($this->service->hasPslEquivalent('max'));
        $this->assertTrue($this->service->hasPslEquivalent('min'));

        // Test type functions
        $this->assertTrue($this->service->hasPslEquivalent('is_string'));
        $this->assertTrue($this->service->hasPslEquivalent('is_int'));
        $this->assertTrue($this->service->hasPslEquivalent('is_array'));

        // Test file functions
        $this->assertTrue($this->service->hasPslEquivalent('file_get_contents'));
        $this->assertTrue($this->service->hasPslEquivalent('file_put_contents'));

        // Test encoding functions
        $this->assertTrue($this->service->hasPslEquivalent('base64_encode'));
        $this->assertTrue($this->service->hasPslEquivalent('json_encode'));
    }

    public function test_has_psl_equivalent_returns_false_for_unknown_function(): void
    {
        $this->assertFalse($this->service->hasPslEquivalent('unknown_function'));
        $this->assertFalse($this->service->hasPslEquivalent('non_existent_func'));
        $this->assertFalse($this->service->hasPslEquivalent('custom_function'));
    }

    public function test_has_psl_equivalent_returns_false_for_empty_string(): void
    {
        $this->assertFalse($this->service->hasPslEquivalent(''));
    }

    public function test_has_psl_equivalent_is_case_sensitive(): void
    {
        $this->assertTrue($this->service->hasPslEquivalent('strlen'));
        $this->assertFalse($this->service->hasPslEquivalent('STRLEN'));
        $this->assertFalse($this->service->hasPslEquivalent('StrLen'));
    }

    public function test_all_restricted_functions_have_psl_equivalents(): void
    {
        $restrictedFunctions = $this->service->getRestrictedFunctions();

        foreach ($restrictedFunctions as $function) {
            $this->assertTrue(
                $this->service->hasPslEquivalent($function),
                "Function '{$function}' should have a PSL equivalent"
            );
            $this->assertNotNull(
                $this->service->getPslEquivalent($function),
                "Function '{$function}' should return a non-null PSL equivalent"
            );
            $this->assertNotEmpty(
                $this->service->getPslEquivalent($function),
                "Function '{$function}' should return a non-empty PSL equivalent"
            );
        }
    }

    public function test_psl_equivalents_follow_expected_format(): void
    {
        $restrictedFunctions = $this->service->getRestrictedFunctions();

        foreach ($restrictedFunctions as $function) {
            $pslEquivalent = $this->service->getPslEquivalent($function);
            $this->assertStringStartsWith(
                'Psl\\',
                $pslEquivalent,
                "PSL equivalent for '{$function}' should start with 'Psl\\'"
            );
            $this->assertStringContainsString(
                '\\',
                $pslEquivalent,
                "PSL equivalent for '{$function}' should contain namespace separators"
            );
        }
    }

    public function test_comprehensive_function_coverage(): void
    {
        $restrictedFunctions = $this->service->getRestrictedFunctions();

        // Verify we have comprehensive coverage across different categories
        $stringFunctions = array_filter($restrictedFunctions, fn ($func) => str_starts_with($func, 'str') || in_array($func, ['trim', 'ltrim', 'rtrim', 'implode', 'explode'])
        );
        $this->assertGreaterThan(10, count($stringFunctions), 'Should have many string functions');

        $arrayFunctions = array_filter($restrictedFunctions, fn ($func) => str_starts_with($func, 'array_') || $func === 'count' || $func === 'in_array'
        );
        $this->assertGreaterThan(10, count($arrayFunctions), 'Should have many array functions');

        $mathFunctions = array_filter($restrictedFunctions, fn ($func) => in_array($func, ['abs', 'max', 'min', 'round', 'ceil', 'floor', 'pow', 'sqrt'])
        );
        $this->assertGreaterThan(5, count($mathFunctions), 'Should have several math functions');

        $typeFunctions = array_filter($restrictedFunctions, fn ($func) => str_starts_with($func, 'is_')
        );
        $this->assertGreaterThan(5, count($typeFunctions), 'Should have several type functions');
    }
}
