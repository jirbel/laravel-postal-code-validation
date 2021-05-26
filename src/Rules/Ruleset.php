<?php

namespace Axlon\PostalCodeValidation\Rules;

use Axlon\PostalCodeValidation\Contracts\Ruleset as RulesetContract;

abstract class Ruleset implements RulesetContract
{
    /**
     * The validation overrides.
     *
     * @var array
     */
    protected $overrides;

    /**
     * Override validation for the given key(s).
     *
     * @param array|string $key
     * @param string|null $rule
     */
    public function override($key, ?string $rule = null): void
    {
        if (is_array($key)) {
            $this->overrides = array_merge(
                $this->overrides,
                array_change_key_case($key, CASE_UPPER),
            );
        } else {
            $this->overrides[strtoupper($key)] = $rule;
        }
    }
}
