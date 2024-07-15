<?php

use PHPUnit\Framework\TestCase;
use Core\ApiResponse;
use Core\Response;

class ResponseTest extends TestCase
{
    public function testAssign()
    {
        $response = new Response();
        $response->assign('name', 'value');

        $data = $response->getData();
        $this->assertEquals('value', $data['name']);
    }

    public function testDisplayPage()
    {
        $response = new Response();
        $response->assign('value', 'Hellow World!');
        $response->displayPage('Core/Test.tpl');

        $expected = "TEST:Hellow World!";
        $this->expectOutputString($expected);
    }

    public function testGetPage()
    {
        $response = new Response();
        $response->assign('value', 'Hellow World!');
        $page = $response->getPage('Core/Test.tpl');
        
        $this->assertEquals('TEST:Hellow World!', $page);
    }
    
}