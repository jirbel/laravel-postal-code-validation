<?php

namespace Axlon\PostalCodeValidation\Tests\Support;

use Axlon\PostalCodeValidation\Support\Facades\PostalCodes;
use Axlon\PostalCodeValidation\Tests\TestCase;

class FacadeTest extends TestCase
{
    public function testItBuildsDependentRules(): void
    {
        $this->assertEquals('postal_code_with:a', PostalCodes::with('a'));
        $this->assertEquals('postal_code_with:a,b', PostalCodes::with('a', 'b'));
        $this->assertEquals('postal_code_with:a,b,c', PostalCodes::with('a', ['b', 'c']));
    }

    public function testItBuildsExplicitRules(): void
    {
        $this->assertEquals('postal_code:a', PostalCodes::for('a'));
        $this->assertEquals('postal_code:a,b', PostalCodes::for('a', 'b'));
        $this->assertEquals('postal_code:a,b,c', PostalCodes::for('a', ['b', 'c']));
    }
}
