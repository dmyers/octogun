<?php

namespace Octokit;

class Client
{
    public $authentication;
    public $connection;
    public $configuration;
    public $request;
    
    public function __construct(array $options = array())
    {
        $this->authentication = new Authentication($this);
        
        $this->connection = new Connection($this);
        
        $this->configuration = new Configuration($this);
        
        $this->request = new Request($this);
    }
    
    public function __call($method, $args)
    {
        $class_name = '\Octokit\Client\\' . ucwords($method);
        
        if (class_exists($class_name)) {
            $class = new $class_name($this);
            
            return $class;
        }
        else {
            throw new \BadMethodCallException('Call to undefined method '.get_class($this).'::'.$method.'()');
        }
    }
}
