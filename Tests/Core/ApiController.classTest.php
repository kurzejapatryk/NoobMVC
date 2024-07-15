<?php

use PHPUnit\Framework\TestCase;
use Core\ApiController;

class ApiControllerTest extends TestCase
{
    public function testSetError()
    {
        $response = new ApiController();
        $response->set('ERROR', true);

        $this->assertTrue($response->ERROR);
    }

    public function testSetMessage()
    {
        $response = new ApiController();
        $response->set('MSG', 'Error occurred');

        $this->assertEquals('Error occurred', $response->MSG);
    }

    public function testSetResult()
    {
        $response = new ApiController();
        $response->set('result', ['key' => 'value']);

        $this->assertEquals(['key' => 'value'], $response->RESULT->result);
    }

    public function testGetJSON()
    {
        $response = new ApiController();
        $response->set('result', ['key' => 'test_value']);
    
        $result = $response->getJSON();
        $this->assertStringContainsString('test_value', $result);
    }

    public function testDisplay()
    {
        $response = new ApiController();
        $response->set('ERROR', true)
                 ->set('MSG', 'Error occurred')
                 ->set('result', ['key' => 'value']);

        ob_start();

        $response->display(false);

        // get the output buffer
        $output = ob_get_clean();

        // check only set values but response has more properties
        $this->assertStringContainsString('"ERROR":true', $output);
        $this->assertStringContainsString('"MSG":"Error occurred"', $output);
        $this->assertStringContainsString('"result":{"key":"value"}', $output);
    }
}