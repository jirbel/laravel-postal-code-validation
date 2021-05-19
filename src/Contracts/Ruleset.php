<?php

namespace Axlon\PostalCodeValidation\Contracts;

interface Ruleset
{
    /**
     * Get the example of valid input for the given key.
     *
     * @param string $key
     * @return string
     */
    public function getExample(string $key): string;

    /**
     * Get the validation rule for the given key.
     *
     * @param string $key
     * @return string
     */
    public function getRule(string $key): string;

    /**
     * Determine whether an example exists for the given key.
     *
     * @param string $key
     * @return bool
     */
    public function hasExample(string $key): bool;

    /**
     * Determine whether a validation rule exists for the given key.
     *
     * @param string $key
     * @return bool
     */
    public function hasRule(string $key): bool;
}
