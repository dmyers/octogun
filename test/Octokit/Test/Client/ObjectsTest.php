<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class ObjectsTest extends \Octokit\Test\OctokitTestCase
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
    
    public function objects()
    {
        return $this->client->objects();
    }
    
    public function testTree()
    {
        $this->request()->setFixture('tree');
        
        $result = $this->objects()->tree('sferik/rails_admin', '3cdfabd973bc3caac209cba903cfdb3bf6636bcd');
        
        $this->assertEquals($result['sha'], '3cdfabd973bc3caac209cba903cfdb3bf6636bcd');
        $this->assertEquals($result['tree'][0]['path'], '.gitignore');
    }
    
    public function testCreateTree()
    {
        $this->request()->setFixture('tree_create');
        
        $response = $this->objects()->createTree('octocat/Hello-World', array(array(
            'path' => 'file.rb',
            'mode' => '100644',
            'type' => 'blob',
            'sha'  => '44b4fc6d56897b048c772eb4087f854f46256132',
        )));
        
        $this->assertEquals($response['sha'], 'cd8274d15fa3ae2ab983129fb037999f264ba9a7');
        $this->assertEquals(count($response['tree']), 1);
        $this->assertEquals($response['tree'][0]['sha'], '7c258a9869f33c1e1e1f74fbb32f07c86cb5a75b');
    }
    
    public function testBlob()
    {
        $this->request()->setFixture('blob');
        
        $blob = $this->objects()->blob('sferik/rails_admin', '94616fa57520ac8147522c7cf9f03d555595c5ea');
        
        $this->assertEquals($blob['sha'], '94616fa57520ac8147522c7cf9f03d555595c5ea');
    }
    
    public function testCreateBlob()
    {
        $this->request()->setFixture('blob_create');
        
        $blob = $this->objects()->createBlob('octocat/Hello-World', 'content');
        
        $this->assertEquals($blob['sha'], '3a0f86fb8db8eea7ccbb9a95f325ddbedfb25e15');
    }
    
    public function testTag()
    {
        $this->request()->setFixture('tag');
        
        $tag = $this->objects()->tag('pengwynn/octokit', '23aad20633f4d2981b1c7209a800db3014774e96');
        
        $this->assertEquals($tag['sha'], '23aad20633f4d2981b1c7209a800db3014774e96');
        $this->assertEquals($tag['message'], "Version 1.4.0\n");
        $this->assertEquals($tag['tag'], 'v1.4.0');
    }
    
    public function testCreateTag()
    {
        $this->request()->setFixture('tag_create');
        
        $tag = $this->objects()->createTag('pengwynn/octokit', 'v9000.0.0', "Version 9000\n", 'f4cdf6eb734f32343ce3f27670c17b35f54fd82e', 'commit', 'Wynn Netherland', 'wynn.netherland@gmail.com', '2012-06-03T17:03:11-07:00');
        
        $this->assertEquals($tag['tag'], 'v9000.0.0');
        $this->assertEquals($tag['message'], "Version 9000\n");
        $this->assertEquals($tag['sha'], '23aad20633f4d2981b1c7209a800db3014774e96');
    }
}
