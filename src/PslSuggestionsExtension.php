<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslRule;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Rules\RestrictedUsage\RestrictedFunctionUsageExtension;
use PHPStan\Rules\RestrictedUsage\RestrictedUsage;

final readonly class PslSuggestionsExtension implements RestrictedFunctionUsageExtension
{
    public function __construct(
        private FunctionMappingService $mappingService
    ) {}

    public function isRestrictedFunctionUsage(FunctionReflection $functionReflection, Scope $scope): ?RestrictedUsage
    {
        $functionName = $functionReflection->getName();

        // Check if this is a native function that has a PSL equivalent
        if ($this->mappingService->hasPslEquivalent($functionName)) {
            return RestrictedUsage::create(
                errorMessage: $this->generateSuggestionMessage($functionName, $this->mappingService->getPslEquivalent($functionName)),
                identifier: 'function.pslSuggestion'
            );
        }

        return null;
    }

    private function generateSuggestionMessage(string $nativeFunction, string $pslFunction): string
    {
        return sprintf(
            'Consider using %s() instead of %s() for better type safety and consistency.',
            $pslFunction,
            $nativeFunction
        );
    }
}
