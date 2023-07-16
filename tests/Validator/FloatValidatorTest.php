<?php

namespace DolphPHP\Validator;

use PHPUnit\Framework\TestCase;

class FloatValidatorTest extends TestCase
{
    public function testCanValidateStrictly(): void
    {
        $validator = new FloatValidator();
        $this->assertTrue($validator->isValid(27.25));
        $this->assertTrue($validator->isValid(23));
        $this->assertTrue($validator->isValid(23.5));
        $this->assertTrue($validator->isValid(1e7));
        $this->assertFalse($validator->isValid('abc'));
        $this->assertFalse($validator->isValid(true));
        $this->assertFalse($validator->isValid('23.5'));
        $this->assertFalse($validator->isValid('23'));
        $this->assertFalse($validator->isArray());
        $this->assertEquals(\DolphPHP\Validator::TYPE_FLOAT, $validator->getType());
    }

    public function testCanValidateLoosely(): void
    {
        $validator = new FloatValidator(true);

        $this->assertTrue($validator->isValid(27.25));
        $this->assertTrue($validator->isValid(23));
        $this->assertTrue($validator->isValid(23.5));
        $this->assertTrue($validator->isValid(1e7));
        $this->assertTrue($validator->isValid('23.5'));
        $this->assertTrue($validator->isValid('23'));
        $this->assertFalse($validator->isValid('abc'));
        $this->assertFalse($validator->isValid(true));
        $this->assertFalse($validator->isArray());
        $this->assertEquals(\DolphPHP\Validator::TYPE_FLOAT, $validator->getType());
    }
}
