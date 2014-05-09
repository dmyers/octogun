<?php

namespace Octogun\Test\Client;

use Octogun\Client;

class DownloadsTest extends \Octogun\Test\OctogunTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
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
