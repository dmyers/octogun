<?php

namespace Octogun;

class Client
{
    protected $authentication;
    protected $connection;
    protected $configuration;
    protected $request;
    
    public function __construct(array $options = [])
    {
        $this->authentication = new Authentication($this);
        
        $this->connection = new Connection($this);
        
        $this->configuration = new Configuration($this, $options);
        
        $this->request = new Request($this);
    }
    
    public function authentication()
    {
        return $this->authentication;
    }
    
    public function connection()
    {
        return $this->connection;
    }
    
    public function configuration()
    {
        return $this->configuration;
    }
    
    public function request()
    {
        return $this->request;
    }
    
    public function __call($method, $args)
    {
        $class_name = '\Octogun\Client\\' . ucwords($method);
        
        if (class_exists($class_name)) {
            $class = new $class_name($this);
            
            return $class;
        }
        else {
            throw new \BadMethodCallException('Call to undefined method '.get_class($this).'::'.$method.'()');
        }
    }
}
