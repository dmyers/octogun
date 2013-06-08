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
        $header = 'HTTP ' . $this->fixture['status'] . ' null';
        
        $response->addHeader($header);
        $response->setContent($this->fixture['body']);
    }
}
