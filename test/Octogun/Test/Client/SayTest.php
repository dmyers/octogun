<?php

namespace Octogun\Test\Client;

class SayTest extends \Octogun\Test\OctogunTestCase
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
        $say_content = $this->fixture('say.txt');
        
        $this->request()->setFixture(array(
            'body'    => $say_content,
            'headers' => array('Content-Type' => 'text/plain'),
        ));
        
        $text = $this->say()->say();
        
        $this->assertTrue(strpos($text, 'Half measures') !== false);
    }
    
    public function testSayWithCustomText()
    {
        $say_content = $this->fixture('say_custom.txt');
        
        $this->request()->setFixture(array(
            'body'    => $say_content,
            'headers' => array('Content-Type' => 'text/plain'),
        ));
        
        $text = $this->say()->say('upset');
        
        $this->assertTrue(strpos($text, 'upset') !== false);
    }
}
