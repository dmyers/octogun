<?php

namespace Octokit\Test;

use Octokit\Client;

class ClientTest extends \Octokit\Test\OctokitTestCase
{
    public function setUp()
    {
        $this->client = new Client();
    }
    
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function configuration()
    {
        return $this->client->configuration();
    }
    
    public function request()
    {
        return $this->client->request();
    }
    
    public function testDefaultUserAgent()
    {
        $this->request()->setFixture(array(
            'headers' => array(
                'X-RateLimit-Limit'     => 5000,
                'X-RateLimit-Remaining' => 5000,
            ),
        ));
        
        $client = $this->client->rateLimit();
        $rate_limit = $client->rateLimit();
    }
    
    public function testCustomUserAgent()
    {
        $this->configuration()->set('user_agent', 'My mashup');
        
        $this->request()->setFixture(array(
            'headers' => array(
                'X-RateLimit-Limit'     => 5000,
                'X-RateLimit-Remaining' => 5000,
            ),
        ));
        
        $client = $this->client->rateLimit();
        $rate_limit = $client->rateLimit();
    }
    
    public function testApiEndpointDefault()
    {
        $this->assertEquals($this->configuration()->get('api_endpoint'), 'https://api.github.com/');
    }
    
    public function testApiEndpointSet()
    {
        $this->configuration()->set('api_endpoint', 'http://foo.dev');
        
        $this->assertEquals($this->configuration()->get('api_endpoint'), 'http://foo.dev');
    }
    
    public function testRequestHostDefault()
    {
        $this->assertNull($this->configuration()->get('request_host'));
    }
    
    public function testRequestHostSettable()
    {
        $this->configuration()->set('request_host', 'github.company.com');
        
        $this->assertEquals($this->configuration()->get('request_host'), 'github.company.com');
    }
}
