<?php

namespace Axlon\PostalCodeValidation\Tests\Validation;

use Axlon\PostalCodeValidation\Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PostalCodeWithTest extends TestCase
{
    public function testItFailsWhenParameterIsInvalid(): void
    {
        $data = ['value' => '1234 AB', 'other' => 'invalid'];
        $rules = ['value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }

    public function testItFailsWhenInputIsInvalid(): void
    {
        $data = ['value' => 'invalid', 'other' => 'NL'];
        $rules = ['value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }

    public function testItFailsWhenInputIsInvalidArray(): void
    {
        $data = ['values' => ['invalid', '4000'], 'others' => ['NL', 'BE']];
        $rules = ['values.*' => 'postal_code_with:others.*'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertContains('values.0', $validator->errors()->keys());
        $this->assertNotContains('values.1', $validator->errors()->keys());
    }

    public function testItFailsWhenInputIsNotStringable(): void
    {
        $data = ['value' => [], 'other' => 'NL'];
        $rules = ['value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }

    /** @link https://github.com/axlon/laravel-postal-code-validation/issues/23 */
    public function testItFailsWhenInputIsNull(): void
    {
        $data = ['value' => null, 'other' => 'NL'];
        $rules = ['value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }

    public function testItFailsWhenOtherContainsError(): void
    {
        $data = ['value' => '1234', 'other' => []];
        $rules = ['other' => 'string', 'value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }

    public function testItPassesValidation(): void
    {
        $data = ['value' => '1234 AB', 'other' => 'NL'];
        $rules = ['value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function testItPassesValidationArray(): void
    {
        $data = ['values' => ['1234 AB', '4000'], 'others' => ['NL', 'BE']];
        $rules = ['values.*' => 'postal_code_with:others.*'];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function testItPassesWhenAtLeastOneParameterMatches(): void
    {
        $data = ['value' => '1234 AB', 'other1' => null, 'other2' => 'BE', 'other4' => 'NL'];
        $rules = ['value' => 'postal_code_with:other1,other2,other3,other4'];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function testItReplacesCountriesInErrorMessages(): void
    {
        $data = ['value' => 'invalid', 'other' => 'NL'];
        $messages = ['postal_code_with' => 'Value must be a valid :countries postal code.'];
        $rules = ['value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules, $messages);

        $this->assertFalse($validator->passes());
        $this->assertContains('Value must be a valid NL postal code.', $validator->errors()->all());
    }

    public function testItReplacesExamplesInErrorMessages(): void
    {
        $data = ['value' => 'invalid', 'other' => 'NL'];
        $messages = ['postal_code_with' => 'Value must be a valid postal code (e.g. :examples).'];
        $rules = ['value' => 'postal_code_with:other'];

        $validator = Validator::make($data, $rules, $messages);

        $this->assertFalse($validator->passes());
        $this->assertContains('Value must be a valid postal code (e.g. 1234 AB).', $validator->errors()->all());
    }

    public function testItThrowsWithoutParameters(): void
    {
        $data = ['value' => '1234 AB'];
        $rules = ['value' => 'postal_code_with'];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Validation rule postal_code_with requires at least 1 parameter.');

        Validator::validate($data, $rules);
    }
}
