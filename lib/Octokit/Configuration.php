<?php

namespace Octokit;

class Configuration extends Api
{
    public $api_version;
    public $api_endpoint;
    public $web_endpoint;
    public $status_api_endpoint;
    public $login;
    public $password;
    public $proxy;
    public $oauth_token;
    public $client_id;
    public $client_secret;
    public $request_host;
    public $user_agent;
    
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
    
    public function set(array $options = array())
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }
}
