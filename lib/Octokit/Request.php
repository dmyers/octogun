<?php

namespace Octokit;

class Request extends Api
{
    public $fixture = false;
    
    public function delete($path, array $options = array())
    {
        $response = $this->sendRequest('delete', $path, $options);
        $body = $this->parseResponse($response);
        
        return $body;
    }
    
    public function get($path, array $options = array())
    {
        $response = $this->sendRequest('get', $path, $options);
        $body = $this->parseResponse($response);
        
        return $body;
    }
    
    public function patch($path, array $options = array())
    {
        $response = $this->sendRequest('patch', $path, $options);
        $body = $this->parseResponse($response);
        
        return $body;
    }
    
    public function post($path, array $options = array())
    {
        $response = $this->sendRequest('post', $path, $options);
        $body = $this->parseResponse($response);
        
        return $body;
    }
    
    public function put($path, array $options = array())
    {
        $response = $this->sendRequest('put', $path, $options);
        $body = $this->parseResponse($response);
        
        return $body;
    }
    
    public function booleanFromResponse($method, $path, array $options = array())
    {
        $response = $this->sendRequest($method, $path, $options);
        
        return $response->getStatusCode() == 204;
    }
    
    public function sendRequest($method, $path, array $options = array())
    {
        $path = ltrim($path, '/'); // leading slash in path fails in github:enterprise
        
        $token = null;
        
        if (!empty($options['access_token'])) {
            $token = $options['access_token'];
        }
        else if (!empty($options['oauth_token'])) {
            $token = $options['oauth_token'];
        }
        else {
            $token = $this->configuration()->get('oauth_token');
        }
        
        $force_urlencoded = false;
        
        if (!empty($options['force_urlencoded']) && $options['force_urlencoded']) {
            $force_urlencoded = true;
        }
        
        $url = null;
        
        if (!empty($options['endpoint'])) {
            $url = $options['endpoint'];
        } else {
            $url = $this->configuration()->get('api_endpoint');
        }
        
        $connection = $this->connection()->create($options);
        $listener = $connection['listener'];
        $options = $connection['options'];
        $connection = $connection['connection'];
        
        if (!empty($options['accept'])) {
            $connection->addHeader('Accept: ' . $options['accept']);
        } else {
            $connection->addHeader('Accept: application/vnd.github.beta+json');
        }
        
        if ($token) {
            $connection->addHeader('Authorization: token ' . $token);
        }
        
        $browser = new \Buzz\Browser();
        
        if ($this->fixture) {
            $request_client = new Request\FixtureRequest($this->fixture);
        }
        else {
            $request_client = new \Buzz\Client\Curl();
        }
        
        $browser->setClient($request_client);
        
        if (!empty($listener)) {
            $browser->addListener($listener);
        }
        
        if (strtolower($method) == 'get') {
            $path .= '?' . http_build_query($options);
        }
        elseif (in_array(strtolower($method), array('patch', 'post', 'put'))) {
            $connection->setContent(json_encode($options, true));
        }
        
        $connection->fromUrl($url);
        $connection->setResource('/' . $path);
        $connection->setMethod($method);
        
        $request_host = $this->configuration()->get('request_host');
        
        if (!empty($request_host)) {
            $connection->setHost($request_host);
        }
        
        $response = $browser->send($connection);
        
        $this->fixture = false;
        
        $this->handleErrors($response);
        
        return $response;
    }
    
    public function parseResponse($response)
    {
        $body = $response->getContent();
        
        $is_json = false;
        
        $content_type = $response->getHeader('Content-Type');
        
        if (!empty($content_type) && strpos($content_type, 'application/json') !== false) {
            $is_json = true;
        }
        elseif (is_string($body) && substr($body, 0, 1) == '{') {
            $is_json = true;
        }
        
        if ($is_json) {
            $body = json_decode($body, true);
        }
        
        return $body;
    }
    
    public function handleErrors($response)
    {
        switch ($response->getStatusCode()) {
            case 400:
                throw new Exception\BadRequestException();
                break;
            case 401:
                throw new Exception\UnauthorizedException();
                break;
            case 403:
                throw new Exception\ForbiddenException();
                break;
            case 404:
                throw new Exception\NotFoundException();
                break;
            case 406:
                throw new Exception\NotAcceptableException();
                break;
            case 422:
                throw new Exception\UnprocessableEntityException();
                break;
            case 500:
                throw new Exception\InternalServerErrorException();
                break;
            case 501:
                throw new Exception\NotImplementedException();
                break;
            case 502:
                throw new Exception\BadGatewayException();
                break;
            case 503:
                throw new Exception\ServiceUnavailableException();
                break;
        }
    }
    
    public function setFixture($fixture)
    {
        if (is_array($fixture)) {
            $this->fixture = $fixture;
            return;
        }
        
        $fixture_path = __DIR__ . '/../../test/Fixtures/' . $fixture . '.json';
        
        if (file_exists($fixture_path)) {
            $fixture_body = file_get_contents($fixture_path);
            
            $this->fixture = array(
                'headers' => array('Content-Type' => 'application/json'),
                'body'    => $fixture_body,
            );
        }
        else {
            throw new \Exception('Unable to find fixture: ' . $fixture);
        }
    }
}
