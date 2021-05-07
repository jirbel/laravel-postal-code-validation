<?php

namespace Axlon\PostalCodeValidation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register postal code validation services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->resolved('validator')) {
            $this->registerRules($validator = $this->app['validator']);
            $this->registerReplacers($validator);
        } else {
            $this->app->resolving('validator', function (Factory $validator) {
                $this->registerReplacers($validator);
                $this->registerRules($validator);
            });
        }

        $this->app->singleton('postal_codes', function () {
            return new PostalCodeValidator(require __DIR__ . '/../resources/patterns.php');
        });

        $this->app->alias('postal_codes', PostalCodeValidator::class);
    }

    /**
     * Register the error message replacers.
     *
     * @param \Illuminate\Validation\Factory $validator
     * @return void
     */
    private function registerReplacers(Factory $validator): void
    {
        $validator->replacer(
            'postal_code',
            'Axlon\PostalCodeValidation\Extensions\PostalCode@replace',
        );

        $validator->replacer(
            'postal_code_with',
            'Axlon\PostalCodeValidation\Extensions\PostalCodeFor@replace',
        );
    }

    /**
     * Register the validation rules.
     *
     * @param \Illuminate\Validation\Factory $validator
     * @return void
     */
    private function registerRules(Factory $validator): void
    {
        $validator->extend(
            'postal_code',
            'Axlon\PostalCodeValidation\Extensions\PostalCode@validate',
        );

        $validator->extendDependent(
            'postal_code_with',
            'Axlon\PostalCodeValidation\Extensions\PostalCodeFor@validate',
        );
    }
}
