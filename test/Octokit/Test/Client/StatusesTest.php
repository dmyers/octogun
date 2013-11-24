<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class StatusesTest extends \PHPUnit_Framework_TestCase
{
    public $client;
    
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function tearDown()
    {
        $this->client->configuration->reset();
    }
    
    public function request()
    {
        return $this->client->request;
    }
    
    public function statuses()
    {
        return $this->client->statuses();
    }
    
    public function testStatuses()
    {
        $this->request()->setFixture('statuses');
        
        $statuses = $this->statuses()->statuses('pengwynn/octokit', '7d069dedd4cb56bf57760688657abd0e6b5a28b8');
        
        $this->assertEquals($statuses[0]['target_url'], 'http://travis-ci.org/pengwynn/octokit/builds/2092930');
    }
    
    public function testCreateStatus()
    {
        $this->request()->setFixture('status');
        
        $info = array(
            'target_url' => 'http://wynnnetherland.com',
        );
        
        $status = $this->statuses()->createStatus('pengwynn/octokit', '7d069dedd4cb56bf57760688657abd0e6b5a28b8', 'success', $info);
        
        $this->assertEquals($status['target_url'], 'http://wynnnetherland.com');
    }
    
    public function testGithubStatus()
    {
        $this->request()->setFixture('github_status');
        
        $github_status = $this->statuses()->githubStatus();
        
        $this->assertEquals($github_status['status'], 'good');
    }
    
    public function testGithubStatusLastMessage()
    {
        $this->request()->setFixture('github_status_last_message');
        
        $last_message = $this->statuses()->githubStatusLastMessage();
        
        $this->assertEquals($last_message['body'], 'Everything operating normally.');
    }
    
    public function testGithubStatusMessages()
    {
        $this->request()->setFixture('github_status_messages');
        
        $status_messages = $this->statuses()->githubStatusMessages();
        
        $this->assertEquals($status_messages[0]['body'], "I'm seeing, like, unicorns man.");
    }
}
