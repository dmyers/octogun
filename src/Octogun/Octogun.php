<?php

namespace Octogun;

class Octogun
{
    const VERSION = '1.0';
    
    public function __construct(array $options = [])
    {
        return new Client($options);
    }
    
    public static function __callStatic($method, $args)
    {
        $class_name = '\Octogun\Client\\' . ucwords($method);
        
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
