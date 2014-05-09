<?php

namespace Octogun\Test\Client;

class GitignoreTest extends \Octogun\Test\OctogunTestCase
{
    public function tearDown()
    {
        $this->configuration()->reset();
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
