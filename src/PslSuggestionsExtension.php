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
        // TODO: Implement logic to determine if function call should be restricted
        return null;
    }

    public function getRestrictionError(FuncCall $funcCall, Scope $scope): ?string
    {
        // TODO: Implement function call analysis and warning generation
        return null;
    }

    private function generateSuggestionMessage(string $nativeFunction, string $pslFunction): string
    {
        // TODO: Implement user-friendly warning message generation
        return '';
    }
}