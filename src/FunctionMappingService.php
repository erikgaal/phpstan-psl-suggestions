<?php

declare(strict_types=1);

namespace ErikGaal\PhpstanPslRule;

final readonly class FunctionMappingService
{
    private const FUNCTION_MAPPINGS = [
        // String functions
        'strlen' => 'Psl\Str\length',
        'substr' => 'Psl\Str\slice',
        'strpos' => 'Psl\Str\search',
        'str_replace' => 'Psl\Str\replace',
        'strtolower' => 'Psl\Str\lowercase',
        'strtoupper' => 'Psl\Str\uppercase',
        'trim' => 'Psl\Str\trim',
        'ltrim' => 'Psl\Str\trim_left',
        'rtrim' => 'Psl\Str\trim_right',
        'str_split' => 'Psl\Str\chunk',
        'implode' => 'Psl\Str\join',
        'explode' => 'Psl\Str\split',
        'str_starts_with' => 'Psl\Str\starts_with',
        'str_ends_with' => 'Psl\Str\ends_with',
        'str_contains' => 'Psl\Str\contains',
        'str_repeat' => 'Psl\Str\repeat',
        'str_pad' => 'Psl\Str\pad_left',
        'strrev' => 'Psl\Str\reverse',
        'ucfirst' => 'Psl\Str\capitalize',
        'lcfirst' => 'Psl\Str\capitalize_words',

        // Array functions
        'array_map' => 'Psl\Vec\map',
        'array_filter' => 'Psl\Vec\filter',
        'array_reduce' => 'Psl\Vec\reduce',
        'array_keys' => 'Psl\Dict\keys',
        'array_values' => 'Psl\Dict\values',
        'array_merge' => 'Psl\Dict\merge',
        'array_slice' => 'Psl\Vec\slice',
        'array_chunk' => 'Psl\Vec\chunk',
        'count' => 'Psl\Vec\count',
        'in_array' => 'Psl\Vec\contains',
        'array_reverse' => 'Psl\Vec\reverse',
        'array_unique' => 'Psl\Vec\unique',
        'array_flip' => 'Psl\Dict\flip',
        'array_search' => 'Psl\Vec\search',
        'array_key_exists' => 'Psl\Dict\contains_key',
        'array_pop' => 'Psl\Vec\last',
        'array_shift' => 'Psl\Vec\first',
        'sort' => 'Psl\Vec\sort',
        'rsort' => 'Psl\Vec\sort',
        'asort' => 'Psl\Dict\sort',
        'arsort' => 'Psl\Dict\sort',

        // Math functions
        'abs' => 'Psl\Math\abs',
        'max' => 'Psl\Math\max',
        'min' => 'Psl\Math\min',
        'round' => 'Psl\Math\round',
        'ceil' => 'Psl\Math\ceil',
        'floor' => 'Psl\Math\floor',
        'pow' => 'Psl\Math\pow',
        'sqrt' => 'Psl\Math\sqrt',
        'log' => 'Psl\Math\log',
        'exp' => 'Psl\Math\exp',
        'sin' => 'Psl\Math\sin',
        'cos' => 'Psl\Math\cos',
        'tan' => 'Psl\Math\tan',

        // Type functions
        'is_string' => 'Psl\Type\string',
        'is_int' => 'Psl\Type\int',
        'is_array' => 'Psl\Type\vec',
        'is_bool' => 'Psl\Type\bool',
        'is_float' => 'Psl\Type\float',
        'is_null' => 'Psl\Type\null',
        'is_numeric' => 'Psl\Type\numeric',
        'is_scalar' => 'Psl\Type\scalar',

        // File functions
        'file_get_contents' => 'Psl\File\read',
        'file_put_contents' => 'Psl\File\write',
        'file_exists' => 'Psl\Filesystem\exists',
        'is_file' => 'Psl\Filesystem\is_file',
        'is_dir' => 'Psl\Filesystem\is_directory',
        'is_readable' => 'Psl\Filesystem\is_readable',
        'is_writable' => 'Psl\Filesystem\is_writable',

        // Encoding functions
        'base64_encode' => 'Psl\Encoding\Base64\encode',
        'base64_decode' => 'Psl\Encoding\Base64\decode',
        'json_encode' => 'Psl\Json\encode',
        'json_decode' => 'Psl\Json\decode',
        'urlencode' => 'Psl\Encoding\Url\encode',
        'urldecode' => 'Psl\Encoding\Url\decode',
        'htmlspecialchars' => 'Psl\Html\encode',
        'htmlspecialchars_decode' => 'Psl\Html\decode',

        // Hash functions
        'md5' => 'Psl\Hash\hash',
        'sha1' => 'Psl\Hash\hash',
        'hash' => 'Psl\Hash\hash',
        'hash_hmac' => 'Psl\Hash\hmac',

        // Random functions
        'rand' => 'Psl\SecureRandom\int',
        'mt_rand' => 'Psl\SecureRandom\int',
        'random_int' => 'Psl\SecureRandom\int',
        'random_bytes' => 'Psl\SecureRandom\bytes',

        // DateTime functions
        'time' => 'Psl\DateTime\now',
        'date' => 'Psl\DateTime\format',
        'strtotime' => 'Psl\DateTime\parse',
    ];

    private readonly array $functionMappings;

    public function __construct(array $functionMappings = [])
    {
        $this->functionMappings = empty($functionMappings) ? self::FUNCTION_MAPPINGS : $functionMappings;
    }

    public function getRestrictedFunctions(): array
    {
        return array_keys($this->functionMappings);
    }

    public function getPslEquivalent(string $nativeFunction): ?string
    {
        return $this->functionMappings[$nativeFunction] ?? null;
    }

    public function hasPslEquivalent(string $nativeFunction): bool
    {
        return array_key_exists($nativeFunction, $this->functionMappings);
    }
}
