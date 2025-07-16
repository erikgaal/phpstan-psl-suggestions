<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslSuggestions;

final readonly class FunctionMappingService
{
    public function __construct(
        private array $functionMappings = []
    ) {}

    public function getRestrictedFunctions(): array
    {
        // TODO: Return array of native function names that have PSL equivalents
        return [];
    }

    public function getPslEquivalent(string $nativeFunction): ?string
    {
        // TODO: Lookup PSL function for a given native function
        return null;
    }

    public function hasPslEquivalent(string $nativeFunction): bool
    {
        // TODO: Check if a native function has a PSL alternative
        return false;
    }
}