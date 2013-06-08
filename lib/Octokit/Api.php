<?php

namespace Octokit;

class Api
{
    public $client;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function authentication()
    {
        return $this->client->authentication;
    }
    
    public function connection()
    {
        return $this->client->connection;
    }
    
    public function configuration()
    {
        return $this->client->configuration;
    }
    
    public function request()
    {
        return $this->client->request;
    }
}
