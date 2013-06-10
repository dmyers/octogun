<?php

namespace Octokit\Test;

use Octokit\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new Client();
    }
    
    public function tearDown()
    {
        $this->client->configuration->reset();
    }
    
    public function configuration()
    {
        return $this->client->configuration;
    }
    
    public function request()
    {
        return $this->client->request;
    }
    
    public function testApiEndpointDefault()
    {
        $this->assertEquals($this->configuration()->api_endpoint, 'https://api.github.com/');
    }
    
    public function testApiEndpointSet()
    {
        $this->configuration()->api_endpoint = 'http://foo.dev';
        
        $this->assertEquals($this->configuration()->api_endpoint, 'http://foo.dev');
    }
    
    public function testRequestHostDefault()
    {
        $this->assertNull($this->configuration()->request_host);
    }
    
    public function testRequestHostSettable()
    {
        $this->configuration()->request_host = 'github.company.com';
        
        $this->assertEquals($this->configuration()->request_host, 'github.company.com');
    }
}
