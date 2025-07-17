<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslRule\Tests;

use PHPStan\Rules\RestrictedUsage\RestrictedFunctionUsageRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class PslSuggestionsExtensionTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new RestrictedFunctionUsageRule(
            $this->getContainer(),
            $this->createReflectionProvider(),
        );
    }

    #[DataProvider('files')]
    public function testRule(string $file, array $expectedErrors): void
    {
        $this->analyse([$file], $expectedErrors);
    }

    public static function files(): iterable
    {
        return [
            'native functions' => [__DIR__ . '/data/native-functions.php', [
                ['Consider using Psl\Str\length() instead of strlen() for better type safety and consistency.', 3],
                ['Consider using Psl\Vec\map() instead of array_map() for better type safety and consistency.', 4],
                ['Consider using Psl\Math\max() instead of max() for better type safety and consistency.', 5],
                ['Consider using Psl\Str\slice() instead of substr() for better type safety and consistency.', 8],
                ['Consider using Psl\Str\search() instead of strpos() for better type safety and consistency.', 9],
                ['Consider using Psl\Str\replace() instead of str_replace() for better type safety and consistency.', 10],
                ['Consider using Psl\Str\lowercase() instead of strtolower() for better type safety and consistency.', 11],
                ['Consider using Psl\Str\trim() instead of trim() for better type safety and consistency.', 12],
                ['Consider using Psl\Dict\keys() instead of array_keys() for better type safety and consistency.', 13],
                ['Consider using Psl\Vec\count() instead of count() for better type safety and consistency.', 14],
            ]],
            'namespaced functions' => [__DIR__ . '/data/namespaced-functions.php', [
                ['Consider using Psl\Str\length() instead of strlen() for better type safety and consistency.', 7],
                ['Consider using Psl\Vec\map() instead of array_map() for better type safety and consistency.', 11],
            ]],
            'class methods' => [__DIR__ . '/data/class-methods.php', [
                ['Consider using Psl\Str\length() instead of strlen() for better type safety and consistency.', 10]
            ]],
            'unknown functions' => [__DIR__ . '/data/unknown-functions.php', []],
        ];
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/../extension.neon',
        ];
    }
}
