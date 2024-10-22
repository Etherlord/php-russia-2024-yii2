<?php

declare(strict_types=1);

use app\infrastructure\EnvType;

/**
 * @param non-empty-string $variableName
 * @param scalar $default
 * @return scalar
 */
function env(string $variableName, EnvType $envType, mixed $default): mixed
{
    /** @psalm-suppress RiskyTruthyFalsyComparison */
    $stringValue = getenv($variableName) ?: $_ENV[$variableName] ?? 'undefined';

    if ($stringValue === 'undefined') {
        return $default;
    }

    $value = match ($envType) {
        EnvType::BOOL => filter_var($stringValue, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE),
        EnvType::FLOAT => filter_var($stringValue, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE),
        EnvType::INT => filter_var($stringValue, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE),
        EnvType::URL => filter_var($stringValue, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE),
        EnvType::ALPHABETIC_STRING => filter_var(
            $stringValue,
            FILTER_VALIDATE_REGEXP,
            [
                'options' => [
                    'regexp' => '/[a-z0-9]/',
                ],
                'flags' => FILTER_NULL_ON_FAILURE,
            ],
        ),
    };

    if ($value === null) {
        throw new RuntimeException(sprintf('Invalid value for env variable "%s"', $variableName));
    }

    return $value;
}
