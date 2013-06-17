<?php

namespace Octokit\Request;

use Buzz\Client\AbstractClient;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

class FixtureRequest extends AbstractClient
{
    public $fixture;
    
    public function __construct($fixture)
    {
        $this->fixture = $fixture;
    }
    
    /**
     * Populates the supplied response with the response for the supplied request.
     *
     * @param RequestInterface $request  A request object.
     * @param MessageInterface $response A response object.
     * 
     * @return void
     */
    public function send(RequestInterface $request, MessageInterface $response)
    {
        if (!isset($this->fixture['status'])) {
            $this->fixture['status'] = 200;
        }
        
        $header = 'HTTP ' . $this->fixture['status'] . ' null';
        
        $response->addHeader($header);
        
        if (!empty($this->fixture['headers'])) {
            $response->addHeaders($this->fixture['headers']);
        }
        
        $response->setContent($this->fixture['body']);
    }
}
