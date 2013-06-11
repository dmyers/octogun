<?php

namespace Octokit;

class Authentication extends Api
{
    public function authentication()
    {
        if ($this->configuration()->login && $this->configuration()->password) {
            return array(
                'login'    => $this->configuration()->login,
                'password' => $this->configuration()->password,
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
        return !empty($this->configuration()->oauth_token);
    }
    
    public function unauthedRateLimited()
    {
        return !empty($this->configuration()->client_id) && !empty($this->configuration()->client_secret);
    }
    
    public function unauthedRateLimitParams()
    {
        return array(
            'client_id'     => $this->configuration()->client_id,
            'client_secret' => $this->configuration()->client_secret,
        );
    }
}
