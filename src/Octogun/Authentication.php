<?php

namespace Octogun;

class Authentication extends Api
{
    public function authentication()
    {
        $login = $this->configuration()->get('login');
        $password = $this->configuration()->get('password');
        
        if (!empty($login) && !empty($password)) {
            return [
                'login'    => $login,
                'password' => $password,
            ];
        }
        
        return [];
    }
    
    public function authenticated()
    {
        $authentication = $this->authentication();
        
        return !empty($authentication);
    }
    
    public function oauthed()
    {
        $oauth_token = $this->configuration()->get('oauth_token');
        
        return !empty($oauth_token);
    }
    
    public function unauthedRateLimited()
    {
        $client_id = $this->configuration()->get('client_id');
        $client_secret = $this->configuration()->get('client_secret');
        
        return !empty($client_id) && !empty($client_secret);
    }
    
    public function unauthedRateLimitParams()
    {
        $client_id = $this->configuration()->get('client_id');
        $client_secret = $this->configuration()->get('client_secret');
        
        return [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
        ];
    }
}
