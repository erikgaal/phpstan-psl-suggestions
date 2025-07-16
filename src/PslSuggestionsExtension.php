<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslSuggestions;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Rules\RestrictedUsage\RestrictedFunctionUsageExtension;
use PHPStan\Rules\RestrictedUsage\RestrictedUsage;

final readonly class PslSuggestionsExtension implements RestrictedFunctionUsageExtension
{
    public function __construct(
        private FunctionMappingService $mappingService
    ) {}

    public function getRestrictedFunctions(): array
    {
        return $this->mappingService->getRestrictedFunctions();
    }

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

    public function getRestrictionError(FuncCall $funcCall, Scope $scope): ?string
    {
        // Get the function name from the function call
        if (! $funcCall->name instanceof \PhpParser\Node\Name) {
            return null; // Skip variable function calls
        }

        $functionName = $funcCall->name->toString();

        // Check if the function is called in global namespace (avoid false positives for namespaced functions)
        if ($funcCall->name->isFullyQualified() || $funcCall->name->isRelative()) {
            return null; // Skip fully qualified or relative function calls
        }

        // Check if this function has a PSL equivalent
        if (! $this->mappingService->hasPslEquivalent($functionName)) {
            return null;
        }

        $pslEquivalent = $this->mappingService->getPslEquivalent($functionName);

        return $this->generateSuggestionMessage($functionName, $pslEquivalent);
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
