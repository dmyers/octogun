<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class EmojisTest extends \Octokit\Test\OctokitTestCase
{
    public $client;
    
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
    
    public function emojis()
    {
        return $this->client->emojis();
    }
    
    public function testGithubMeta()
    {
        $this->request()->setFixture('emojis');
        
        $emojis = $this->emojis()->emojis();
        
        $this->assertEquals($emojis['metal'], 'https://a248.e.akamai.net/assets.github.com/images/icons/emoji/metal.png?v5');
    }
}
