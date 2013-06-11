<?php

namespace Octokit;

class Connection extends Api
{
    public function create(array $options = array())
    {
        $options = array_merge(array(
            'authenticate'     => true,
            'force_urlencoded' => false,
            'raw'              => false,
        ), $options);
        
        if (!empty($this->configuration()->proxy)) {
            $options = array_merge(array(
                'proxy' => $this->configuration()->proxy,
            ), $options);
        }
        
        if (!$this->authentication()->oauthed()
            && !$this->authentication()->authenticated()
            && $this->authentication()->unauthedRateLimited()
        ) {
            $options = array_merge(array(
                'params' => $this->authentication()->unauthedRateLimitParams(),
            ), $options);
        }
        
        $factory = new \Buzz\Message\Factory\Factory();
        $connection = $factory->createRequest();
        $listener = false;
        
        if ($options['authenticate'] && $this->authentication()->authenticated()) {
            $listener = new \Buzz\Listener\BasicAuthListener(
                $this->configuration()->login, $this->configuration()->password
            );
        }
        
        if ($options['force_urlencoded']) {
            $connection->addHeader('Content-Type: application/x-www-form-urlencoded');
        }
        else {
            $connection->addHeader('Content-Type: application/json');
        }
        
        $connection->addHeader('User-Agent:' . $this->configuration()->user_agent);
        
        return array(
            'connection' => $connection,
            'listener'   => $listener,
        );
    }
}
