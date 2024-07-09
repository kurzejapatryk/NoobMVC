<?php

use Core\Tables;
use PHPUnit\Framework\TestCase;

class TablesTest extends TestCase
{
    
    public function testPOSTWithNonExistingKey()
    {
        $result = Tables::POST('non_existing_key');
        $this->assertFalse($result);
    }


    public function testGETWithNonExistingKey()
    {
        $result = Tables::GET('non_existing_key');
        $this->assertFalse($result);
    }


    public function testCOOKIESWithNonExistingKey()
    {
        $result = Tables::COOKIES('non_existing_key');
        $this->assertNull($result);
    }
}
