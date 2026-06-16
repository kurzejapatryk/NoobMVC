<?php

use PHPUnit\Framework\TestCase;
use Core\Authentication;
use Models\User;
use Models\Session;

class FakeUserForAuthTest extends User
{
    public static $users = [];
    public static $saved = false;

    public static function resetState() : void
    {
        self::$users = [];
        self::$saved = false;
    }

    public function getByUserName(string $user_name) : User|false
    {
        if(isset(self::$users[$user_name])){
            $data = self::$users[$user_name];
            $this->id = $data['id'];
            $this->role = $data['role'];
            $this->user_name = $user_name;

            $ref = new ReflectionClass($this);
            $prop = $ref->getProperty('password');
            $prop->setAccessible(true);
            $prop->setValue($this, $data['password']);
            return $this;
        }

        return false;
    }

    public function save() : self
    {
        self::$saved = true;
        if($this->user_name){
            self::$users[$this->user_name] = [
                'id' => $this->id,
                'role' => $this->role,
                'password' => $this->getPassword(),
            ];
        }
        return $this;
    }

    public function get() : self
    {
        return $this;
    }
}

class FakeSessionForAuthTest extends Session
{
    public static $saved = false;
    public static $savedAuthKey = null;
    public static $savedExpire = null;

    public static function resetState() : void
    {
        self::$saved = false;
        self::$savedAuthKey = null;
        self::$savedExpire = null;
    }

    public function getBySessionID(string $id) : Session
    {
        return $this;
    }

    public function save() : self
    {
        self::$saved = true;
        self::$savedAuthKey = $this->auth_key;
        self::$savedExpire = $this->expire_datetime;
        return $this;
    }
}

class AuthenticationForTest extends Authentication
{
    protected function createUserModel() : User
    {
        return new FakeUserForAuthTest();
    }

    protected function createSessionModel() : Session
    {
        return new FakeSessionForAuthTest();
    }
}

class AuthenticationClassTest extends TestCase
{
    protected function setUp(): void
    {
        if(session_status() !== PHP_SESSION_ACTIVE){
            @session_start();
        }

        $_SESSION = [];
        FakeUserForAuthTest::resetState();
        FakeSessionForAuthTest::resetState();
    }

    public function testLoginSetsAuthKeyAndSession()
    {
        $hash = password_hash('GoodPass123!', PASSWORD_DEFAULT);
        FakeUserForAuthTest::$users['john'] = [
            'id' => 1,
            'role' => 0,
            'password' => $hash,
        ];

        $auth = new AuthenticationForTest(false);
        $result = $auth->login('john', 'GoodPass123!');

        $this->assertTrue($result);
        $this->assertTrue(isset($_SESSION['AUTH_KEY']));
        $this->assertTrue(strlen($_SESSION['AUTH_KEY']) >= 64);
        $this->assertTrue(FakeSessionForAuthTest::$saved);
    }

    public function testLoginRejectsNonAdminWhenAdminFlagSet()
    {
        $hash = password_hash('GoodPass123!', PASSWORD_DEFAULT);
        FakeUserForAuthTest::$users['jane'] = [
            'id' => 2,
            'role' => 0,
            'password' => $hash,
        ];

        $auth = new AuthenticationForTest(false);
        $result = $auth->login('jane', 'GoodPass123!', true);

        $this->assertFalse($result);
        $this->assertFalse(isset($_SESSION['AUTH_KEY']));
    }

    public function testLoginRehashesLegacyPassword()
    {
        $legacyHash = md5('LegacyPass123!' . SALT);
        FakeUserForAuthTest::$users['legacy'] = [
            'id' => 3,
            'role' => 1,
            'password' => $legacyHash,
        ];

        $auth = new AuthenticationForTest(false);
        $result = $auth->login('legacy', 'LegacyPass123!');

        $this->assertTrue($result);
        $this->assertTrue(FakeUserForAuthTest::$saved);
        $newHash = FakeUserForAuthTest::$users['legacy']['password'];
        $this->assertNotEquals($legacyHash, $newHash);
        $this->assertTrue(password_verify('LegacyPass123!', $newHash));
    }

    public function testLogoutInvalidatesSession()
    {
        $hash = password_hash('GoodPass123!', PASSWORD_DEFAULT);
        FakeUserForAuthTest::$users['john'] = [
            'id' => 1,
            'role' => 0,
            'password' => $hash,
        ];

        $auth = new AuthenticationForTest(false);
        $auth->login('john', 'GoodPass123!');

        FakeSessionForAuthTest::resetState();
        $auth->logout();

        $this->assertTrue(FakeSessionForAuthTest::$saved);
        $this->assertEquals(0, FakeSessionForAuthTest::$savedExpire);
    }
}
