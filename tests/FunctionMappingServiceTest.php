<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslSuggestions\Tests;

use ErikGaal\PhpstanPslSuggestions\FunctionMappingService;
use PHPUnit\Framework\TestCase;

final class FunctionMappingServiceTest extends TestCase
{
    private FunctionMappingService $service;

    protected function setUp(): void
    {
        $this->service = new FunctionMappingService();
    }

    public function test_can_be_instantiated(): void
    {
        $this->assertInstanceOf(FunctionMappingService::class, $this->service);
    }

    public function test_get_restricted_functions_returns_array(): void
    {
        $result = $this->service->getRestrictedFunctions();
        $this->assertIsArray($result);
    }

    public function test_get_psl_equivalent_returns_null_for_unknown_function(): void
    {
        $result = $this->service->getPslEquivalent('unknown_function');
        $this->assertNull($result);
    }

    public function test_has_psl_equivalent_returns_false_for_unknown_function(): void
    {
        $result = $this->service->hasPslEquivalent('unknown_function');
        $this->assertFalse($result);
    }
}