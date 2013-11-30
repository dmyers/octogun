<?php

namespace Octokit;

class Authentication extends Api
{
    public function authentication()
    {
        if (!empty($this->configuration()->get('login')) && !empty($this->configuration()->get('password'))) {
            return array(
                'login'    => $this->configuration()->get('login'),
                'password' => $this->configuration()->get('password'),
            );
        }
        
        return array();
    }
    
    public function authenticated()
    {
        $authentication = $this->authentication();
        
        return !empty($authentication);
    }
    
    public function oauthed()
    {
        return !empty($this->configuration()->get('oauth_token'));
    }
    
    public function unauthedRateLimited()
    {
        return !empty($this->configuration()->get('client_id')) && !empty($this->configuration()->get('client_secret'));
    }
    
    public function unauthedRateLimitParams()
    {
        return array(
            'client_id'     => $this->configuration()->get('client_id'),
            'client_secret' => $this->configuration()->get('client_secret'),
        );
    }
}
