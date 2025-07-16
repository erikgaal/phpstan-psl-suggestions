<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslSuggestions\Tests;

use ErikGaal\PhpstanPslSuggestions\FunctionMappingService;
use ErikGaal\PhpstanPslSuggestions\PslSuggestionsExtension;
use PHPUnit\Framework\TestCase;

final class PslSuggestionsExtensionTest extends TestCase
{
    private PslSuggestionsExtension $extension;
    private FunctionMappingService $mappingService;

    protected function setUp(): void
    {
        $this->mappingService = new FunctionMappingService();
        $this->extension = new PslSuggestionsExtension($this->mappingService);
    }

    public function test_can_be_instantiated(): void
    {
        $this->assertInstanceOf(PslSuggestionsExtension::class, $this->extension);
    }

    public function test_get_restricted_functions_delegates_to_mapping_service(): void
    {
        $result = $this->extension->getRestrictedFunctions();
        $this->assertIsArray($result);
    }
}