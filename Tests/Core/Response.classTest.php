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

    public function testGetJSON()
    {
        $response = new Response();
        $response->assign('value', 'Hellow World!');
        $result = $response->getJSON(true);
        $result = json_decode($result, true);

        $expected = array(
            'version' => VERSION,
            'core_version' => CORE_VERSION,
            'api_version' => API_VERSION,
            'language' => LANGUAGE,
            'url' => URL,
            'value' => 'Hellow World!'
        );

        // check only set values but response has more properties
        $this->assertArrayHasKey('version', $result);
        $this->assertArrayHasKey('core_version', $result);
        $this->assertArrayHasKey('api_version', $result);
        $this->assertArrayHasKey('language', $result);
        $this->assertArrayHasKey('url', $result);
        $this->assertArrayHasKey('value', $result);
        $this->assertEquals($expected['value'], $result['value']);
        $this->assertEquals($expected['version'], $result['version']);
        $this->assertEquals($expected['core_version'], $result['core_version']);
        $this->assertEquals($expected['api_version'], $result['api_version']);
        $this->assertEquals($expected['language'], $result['language']);
        $this->assertEquals($expected['url'], $result['url']);
        
    }
}