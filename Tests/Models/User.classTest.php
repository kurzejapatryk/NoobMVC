<?php

use PHPUnit\Framework\TestCase;
use Models\User;

class UserClassTest extends TestCase
{
    public function testSetPasswordUsesModernHash()
    {
        $user = new User();
        $user->setPassword('StrongPass123!');

        $hash = $user->getPassword();

        $this->assertNotEquals(md5('StrongPass123!' . SALT), $hash);
        $this->assertTrue(password_verify('StrongPass123!', $hash));
    }

    public function testVerifyPasswordSupportsLegacyHash()
    {
        $user = new User();
        $legacyHash = md5('LegacyPass123!' . SALT);

        $ref = new ReflectionClass($user);
        $prop = $ref->getProperty('password');
        $prop->setAccessible(true);
        $prop->setValue($user, $legacyHash);

        $this->assertTrue($user->verifyPassword('LegacyPass123!'));
        $this->assertTrue($user->passwordNeedsRehash());
    }

    public function testVerifyPasswordRejectsWrongPassword()
    {
        $user = new User();
        $user->setPassword('ValidPass123!');

        $this->assertFalse($user->verifyPassword('WrongPass123!'));
    }
}
