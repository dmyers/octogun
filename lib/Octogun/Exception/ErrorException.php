<?php

namespace Octogun\Exception;

class ErrorException extends \RuntimeException
{
    protected $statusCode = 0;
    public $connection;
    public $response;
    
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $this->statusCode, $previous);
    }
    
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
    
    public function setResponse($response)
    {
        $this->response = $response;
    }
    
    public function responseBody()
    {
        $response_body = $this->response->getContent();
        
        if (!empty($response_body)) {
            if (is_string($response_body)) {
                $response_body = json_decode($response_body, true);
            }
        }
        else {
            $response_body = null;
        }
        
        return $response_body;
    }
    
    public function buildErrorMessage()
    {
        if (empty($this->response)) {
            return null;
        }
        
        $connection = $this->connection;
        $method = $connection->getMethod();
        $url = $connection->getUrl();
        $status = $this->response->getStatusCode();
        $response_body = $this->responseBody();
        
        $message = '';
        $errors = '';
        
        if ($response_body) {
            if (isset($response_body['error'])) {
                $message = ': ' . $response_body['error'];
            }
            elseif (isset($response_body['message'])) {
                $message = ': ' . $response_body['message'];
            }
        }
        
        if (empty($message) && isset($response_body['errors'])) {
            $error_msgs = array();
            
            foreach ($response_body['errors'] as $error) {
                $error_msgs[] = $error['message'];
            }
            
            if (!empty($errors)) {
                $errors = implode(', ', $error_msgs);
            }
        }
        
        $message = $method . ' ' . $url . ': ' . $status . $message . $errors;
        
        $this->message = $message;
    }
}
