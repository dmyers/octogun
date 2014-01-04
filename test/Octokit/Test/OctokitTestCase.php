<?php

namespace Octokit\Test;

class OctokitTestCase extends \PHPUnit_Framework_TestCase
{
    public function configuration()
    {
        return $this->client->configuration();
    }
    
    public function request()
    {
        return $this->client->request();
    }
}
