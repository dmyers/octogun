<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class DownloadsTest extends \Octokit\Test\OctokitTestCase
{
    public $client;
    
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
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
    
    public function downloads()
    {
        return $this->client->downloads();
    }
    
    public function testDownloads()
    {
        $this->request()->setFixture('downloads');
        
        $downloads = $this->downloads()->downloads('github/hubot');
        
        $this->assertEquals($downloads[0]['description'], 'Robawt');
    }
    
    public function testDownload()
    {
        $this->request()->setFixture('download');
        
        $download = $this->downloads()->download('github/hubot', 165347);
        
        $this->assertEquals($download['id'], 165347);
        $this->assertEquals($download['name'], 'hubot-2.1.0.tar.gz');
    }
    
    public function testDeleteDownload()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->downloads()->deleteDownload('github/hubot', 165347);
        
        $this->assertTrue($result);
    }
}
