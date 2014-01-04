<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class GitignoreTest extends \Octokit\Test\OctokitTestCase
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
    
    public function gitignore()
    {
        return $this->client->gitignore();
    }
    
    public function testGitignoreTemplates()
    {
        $this->request()->setFixture('gitignore_templates');
        
        $templates = $this->gitignore()->gitignoreTemplates();
        
        $this->assertEquals($templates[0], 'Actionscript');
    }
    
    public function testGitignoreTemplate()
    {
        $this->request()->setFixture('gitignore_template_ruby');
        
        $template = $this->gitignore()->gitignoreTemplate('Ruby');
        
        $this->assertEquals($template['name'], 'Ruby');
        $this->assertTrue(strpos($template['source'], "*.gem\n") !== false);
    }
}
