<?php

namespace Octokit\Test\Client;

class SayTest extends \Octokit\Test\OctokitTestCase
{
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function say()
    {
        return $this->client->say();
    }
    
    public function testSayWithoutCustomText()
    {
        $say_content = file_get_contents(__DIR__ . '/../../../Fixtures/say.txt');
        
        $this->request()->setFixture(array(
            'body'    => $say_content,
            'headers' => array('Content-Type' => 'text/plain'),
        ));
        
        $text = $this->say()->say();
        
        $this->assertTrue(strpos($text, 'Half measures') !== false);
    }
    
    public function testSayWithCustomText()
    {
        $say_content = file_get_contents(__DIR__ . '/../../../Fixtures/say_custom.txt');
        
        $this->request()->setFixture(array(
            'body'    => $say_content,
            'headers' => array('Content-Type' => 'text/plain'),
        ));
        
        $text = $this->say()->say('upset');
        
        $this->assertTrue(strpos($text, 'upset') !== false);
    }
}
