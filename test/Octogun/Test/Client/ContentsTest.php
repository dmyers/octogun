<?php

namespace Octogun\Test\Client;

use Octogun\Client;

class ContentsTest extends \Octogun\Test\OctogunTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function contents()
    {
        return $this->client->contents();
    }
    
    public function testReadme()
    {
        $this->request()->setFixture('readme');
        
        $readme = $this->contents()->readme('pengwynn/octokit');
        
        $this->assertEquals($readme['encoding'], 'base64');
        $this->assertEquals($readme['type'], 'file');
    }
    
    public function testContents()
    {
        $this->request()->setFixture('contents');
        
        $contents = $this->contents()->contents('pengwynn/octokit', array(
            'path' => 'lib/octokit.rb',
        ));
        
        $this->assertEquals($contents['path'], 'lib/octokit.rb');
        $this->assertEquals($contents['name'], 'lib/octokit.rb');
        $this->assertEquals($contents['encoding'], 'base64');
        $this->assertEquals($contents['type'], 'file');
    }
    
    public function testArchiveLink()
    {
        $this->request()->setFixture(array(
            'body'    => '',
            'headers' => array('location' => 'https://nodeload.github.com/repos/pengwynn/octokit/tarball/')
        ));
        
        $archive_link = $this->contents()->archiveLink('pengwynn/octokit', array(
            'ref' => 'master',
        ));
        
        $this->assertEquals($archive_link, 'https://nodeload.github.com/repos/pengwynn/octokit/tarball/');
    }
    
    public function testCreateContentsWithPath()
    {
        $this->request()->setFixture('create_content');
        
        $response = $this->contents()->createContents('pengwynn/api-sandbox', 'foo/bar/baz.txt', 'I am commit-ing', 'Here be the content');
        
        $this->assertEquals($response['commit']['sha'], '4810b8a0d076f20169bd2acca6501112f4d93e7d');
    }
    
    public function testUpdateContentsWithPath()
    {
        $this->request()->setFixture('update_content');
        
        $response = $this->contents()->updateContents('pengwynn/api-sandbox', 'foo/bar/baz.txt', 'I am commit-ing', '4d149b826e7305659006eb64cfecd3be68d0f2f0', 'Here be moar content');
        
        $this->assertEquals($response['commit']['sha'], '15ab9bfe8985e69d64e3d06b2eaf252cfbf43a6e');
    }
    
    public function testDeleteContents()
    {
        $this->request()->setFixture('delete_content');
        
        $response = $this->contents()->deleteContents('pengwynn/api-sandbox', 'foo/bar/baz.txt', 'I am rm-ing', '4d149b826e7305659006eb64cfecd3be68d0f2f0');
        
        $this->assertEquals($response['commit']['sha'], '960a747b2f5c3837184b84e1f8cae7ef1a765e2f');
    }
}
