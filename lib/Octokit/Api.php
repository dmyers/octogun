<?php

namespace Octokit;

class Api
{
    public $client;
    public $aliases = array();
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function authentication()
    {
        return $this->client->authentication();
    }
    
    public function connection()
    {
        return $this->client->connection();
    }
    
    public function configuration()
    {
        return $this->client->configuration();
    }
    
    public function request()
    {
        return $this->client->request();
    }
    
    public function __call($method, $args)
    {
        if (array_key_exists($method, $this->aliases)) {
            $alias = $this->aliases[$method];
            
            return call_user_func_array(array($this, $alias), $args);
        }
        else {
            throw new \BadMethodCallException('Call to undefined method '.get_class($this).'::'.$method.'()');
        }
    }
}
