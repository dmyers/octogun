<?php

namespace Octogun\Test\Client;

class MarkdownTest extends \Octogun\Test\OctogunTestCase
{
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function markdown()
    {
        return $this->client->markdown();
    }
    
    public function testMarkdown()
    {
        $markdown_content = $this->fixture('markdown_gfm');
        
        $this->request()->setFixture(array(
            'body' => $markdown_content,
        ));
        
        $text = 'This is for #111';
        
        $markdown = $this->markdown()->markdown($text, array(
            'context' => 'pengwynn/octokit',
            'mode'    => 'gfm',
        ));
        
        $this->assertTrue(strpos($markdown, 'https://github.com/pengwynn/octokit/issues/111') !== false);
    }
}
