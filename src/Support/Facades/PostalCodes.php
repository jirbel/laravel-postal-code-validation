<?php

namespace Axlon\PostalCodeValidation\Support\Facades;

use Axlon\PostalCodeValidation\Support\Constraint;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getExample(string $key)
 * @method static string getRule(string $key)
 * @method static bool hasExample(string $key)
 * @method static bool hasRule(string $key)
 * @method static void override(array|string $countryCode, string|null $pattern = null)
 *
 * @see \Axlon\PostalCodeValidation\Contracts\Ruleset
 */
class PostalCodes extends Facade
{
    /**
     * Get a postal_code constraint builder instance.
     *
     * @param string|string[] ...$parameters
     * @return \Axlon\PostalCodeValidation\Support\Constraint
     */
    public static function for(...$parameters): Constraint
    {
        return new Constraint('postal_code', $parameters);
    }

    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'postal_codes';
    }

    /**
     * Validate the given value.
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public static function validate(string $key, string $value): bool
    {
        return preg_match(static::getRule($key), $value) === 1;
    }

    /**
     * Get a postal_code_with constraint builder instance.
     *
     * @param string|string[] ...$parameters
     * @return \Axlon\PostalCodeValidation\Support\Constraint
     */
    public static function with(...$parameters): Constraint
    {
        return new Constraint('postal_code_with', $parameters);
    }
}
