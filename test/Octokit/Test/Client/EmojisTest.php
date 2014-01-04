<?php

namespace Octokit\Test\Client;

class EmojisTest extends \Octokit\Test\OctokitTestCase
{
    public function tearDown()
    {
        $this->configuration()->reset();
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
