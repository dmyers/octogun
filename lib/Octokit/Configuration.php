<?php

namespace Octokit;

class Configuration extends Api
{
    protected $api_version;
    protected $api_endpoint;
    protected $web_endpoint;
    protected $status_api_endpoint;
    protected $login;
    protected $password;
    protected $proxy;
    protected $oauth_token;
    protected $client_id;
    protected $client_secret;
    protected $request_host;
    protected $user_agent;
    
    const DEFAULT_API_VERSION = 3;
    const DEFAULT_API_ENDPOINT = 'https://api.github.com/';
    const DEFAULT_WEB_ENDPOINT = 'https://github.com/';
    const DEFAULT_STATUS_API_ENDPOINT = 'https://status.github.com/api/';
    const DEFAULT_USER_AGENT = 'Octokit PHP Package';
    
    public function __construct($client, array $options = array())
    {
        parent::__construct($client);
        
        $this->reset();
        $this->set($options);
    }
    
    public function reset()
    {
        $this->api_version = self::DEFAULT_API_VERSION;
        $this->api_endpoint = self::DEFAULT_API_ENDPOINT;
        $this->web_endpoint = self::DEFAULT_WEB_ENDPOINT;
        $this->status_api_endpoint = self::DEFAULT_STATUS_API_ENDPOINT;
        $this->login = null;
        $this->password = null;
        $this->proxy = null;
        $this->oauth_token = null;
        $this->client_id = null;
        $this->client_secret = null;
        $this->request_host = null;
        $this->user_agent = self::DEFAULT_USER_AGENT;
    }
    
    public function set($option, $value = null)
    {
        if (is_array($option)) {
            foreach ($option as $key => $value) {
                $this->set($key, $value);
            }
        }
        else {
            $this->$option = $value;
        }
    }
    
    public function get($option)
    {
        if (property_exists($this, $option)) {
            return $this->$option;
        }
        
        return null;
    }
}
