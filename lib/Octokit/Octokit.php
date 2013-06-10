<?php

namespace Octokit;

class Octokit
{
    const VERSION = '1.0';
    
    public function __construct(array $options = array())
    {
        return new Client($options);
    }
    
    public static function __callStatic($method, $args)
    {
        $class_name = '\Octokit\Client\\' . ucwords($method);
        
        if (class_exists($class_name)) {
            $client = new Client();
            $class = new $class_name($client);
            
            return $class;
        }
        else {
            throw new \BadMethodCallException('Invalid method call. Method '.$method.' does not exist.');
        }
    }
}
