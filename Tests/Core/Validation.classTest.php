<?php

use Core\Validation;

class ValidationTest extends PHPUnit\Framework\TestCase
{
    public function testRequiredField()
    {
        $validation = new Validation();
        $validation->name('username')->value('')->required();

        $this->assertFalse($validation->isSuccess());
        $this->assertEquals(['username' => ['error' => 'val_required']], $validation->getErrors());
    }

    public function testMinLength()
    {
        $validation = new Validation();
        $validation->name('password')->value('abc')->min(6);

        $this->assertFalse($validation->isSuccess());
        $this->assertEquals(['password' => ['error' => 'val_min']], $validation->getErrors());
    }

    public function testMaxLength()
    {
        $validation = new Validation();
        $validation->name('email')->value('test@example.com')->max(10);

        $this->assertFalse($validation->isSuccess());
        $this->assertEquals(['email' => ['error' => 'val_max']], $validation->getErrors());
    }

    public function testPattern()
    {
        $validation = new Validation();
        $validation->name('phone')->value('123')->min(9)->max(12)->pattern('tel');

        $this->assertFalse($validation->isSuccess());
        $this->assertEquals(['phone' => ['error' => 'val_pattern', 'error' => 'val_min']], $validation->getErrors());
    }

    public function testCustomPattern()
    {
        $validation = new Validation();
        $validation->name('custom')->value('abc')->customPattern('#^[a-z]+$#');

        $this->assertFalse($validation->isSuccess());
        $this->assertEquals(['custom' => ['error' => 'val_pattern']], $validation->getErrors());
    }

    public function testSuccess()
    {
        $validation = new Validation();
        $validation->name('age')->value(25)->min(18)->max(30);

        $this->assertTrue($validation->isSuccess());
        $this->assertEmpty($validation->getErrors());
    }
}
