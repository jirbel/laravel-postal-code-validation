<?php

namespace Axlon\PostalCodeValidation\Rules\ISO3166_1;

use Axlon\PostalCodeValidation\Rules\Ruleset;

class Alpha2 extends Ruleset
{
    /**
     * The validation examples.
     *
     * @var array
     */
    protected $examples;

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $rules;

    /**
     * Create a new ISO 3166-1 alpha 2 validation ruleset.
     *
     * @return void
     */
    public function __construct()
    {
        $this->examples = require __DIR__ . '/../../../resources/examples.php';
        $this->rules = require __DIR__ . '/../../../resources/patterns.php';
    }

    /**
     * @inheritDoc
     */
    public function getExample(string $key): string
    {
        return $this->examples[$key];
    }

    /**
     * @inheritDoc
     */
    public function getRule(string $key): string
    {
        $key = strtoupper($key);

        if (isset($this->overrides[$key])) {
            return $this->overrides[$key];
        }

        return $this->rules[$key] ?: '/.*/';
    }

    /**
     * @inheritDoc
     */
    public function hasExample(string $key): bool
    {
        return array_key_exists(strtoupper($key), $this->examples);
    }

    /**
     * @inheritDoc
     */
    public function hasRule(string $key): bool
    {
        return array_key_exists(strtoupper($key), $this->rules);
    }
}
