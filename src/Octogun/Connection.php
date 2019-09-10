<?php

namespace Octogun;

class Connection extends Api
{
    public function create(array $options = [])
    {
        $options = array_merge(array(
            'authenticate'     => true,
            'force_urlencoded' => false,
            'raw'              => false,
        ), $options);
        
        $proxy = $this->configuration()->get('proxy');
        
        if (!empty($proxy)) {
            $options = array_merge(array('proxy' => $proxy), $options);
        }
        
        $connection = new \Buzz\Message\Request();
        
        if (!$this->authentication()->oauthed()
            && !$this->authentication()->authenticated()
            && $this->authentication()->unauthedRateLimited()
        ) {
            $options = array_merge($this->authentication()->unauthedRateLimitParams(), $options);
        }
        
        $listener = false;
        
        if ($options['authenticate'] && $this->authentication()->authenticated()) {
            $authentication = $this->authentication()->authentication();
            
            $listener = new \Buzz\Listener\BasicAuthListener(
                $authentication['login'], $authentication['password']
            );
        }
        
        if ($options['force_urlencoded']) {
            $connection->addHeader('Content-Type: application/x-www-form-urlencoded');
        }
        else {
            $connection->addHeader('Content-Type: application/json');
        }
        
        $connection->addHeader('User-Agent: ' . $this->configuration()->get('user_agent'));
        
        return array(
            'connection' => $connection,
            'listener'   => $listener,
            'options'    => $options,
        );
    }
}
