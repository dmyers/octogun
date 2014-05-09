<?php

namespace Octogun\Test;

use Octogun\Client;

class OctogunTestCase extends \PHPUnit_Framework_TestCase
{
    protected $client;
    
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
    
    public function fixture($fixture)
    {
        return file_get_contents(__DIR__ . '/../../Fixtures/' . $fixture);
    }
}
