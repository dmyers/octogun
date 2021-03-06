<?php

namespace Octogun\Test\Client;

class GithubTest extends \Octogun\Test\OctogunTestCase
{
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function github()
    {
        return $this->client->github();
    }
    
    public function testGithubMeta()
    {
        $this->request()->setFixture('github_meta');
        
        $github_meta = $this->github()->githubMeta();
        
        $this->assertEquals($github_meta['git'][0], '127.0.0.1/32');
    }
}
