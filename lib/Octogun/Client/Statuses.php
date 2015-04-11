<?php

namespace Octogun\Client;

use Octogun\Api;

class Statuses extends Api
{
    public $aliases = array(
        'listStatuses' => 'statuses',
    );
    
    /**
     * List all statuses for a given commit.
     * 
     * @see http://developer.github.com/v3/repos/status
     * 
     * @param string $repo    A GitHub repository.
     * @param string $sha     The SHA1 for the commit.
     * @param array  $options Optional options.
     * 
     * @return array A list of statuses.
     */
    public function statuses($repo, $sha, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/statuses/' . $sha, $options);
    }
    
    /**
     * Create status for a commit.
     * 
     * @see http://developer.github.com/v3/repos/status
     * 
     * @param string $repo    A GitHub repository.
     * @param string $sha     The SHA1 for the commit.
     * @param string $state   The state: pending, success, failure, error.
     * @param array  $options Optional options.
     * 
     * @return array A status.
     */
    public function createStatus($repo, $sha, $state, array $options = array())
    {
        $options = array_merge($options, array(
            'state' => $state,
        ));
        
        return $this->request()->post('repos/' . $repo . '/statuses/' . $sha, $options);
    }
    
    /**
     * Returns the current system status.
     * 
     * @see https://status.github.com/api#api-current-status
     * 
     * @return array GitHub status.
     */
    public function githubStatus()
    {
        $options = array(
            'endpoint' => $this->configuration()->get('status_api_endpoint'),
        );
        
        return $this->request()->get('status.json', $options);
    }
    
    /**
     * Returns the last human communication, status, and timestamp.
     * 
     * @see https://status.github.com/api#api-last-message
     * 
     * @return array GitHub status last message.
     */
    public function githubStatusLastMessage()
    {
        $options = array(
            'endpoint' => $this->configuration()->get('status_api_endpoint'),
        );
        
        return $this->request()->get('last-message.json', $options);
    }
    
    /**
     * Returns the most recent human communications with status and timestamp.
     * 
     * @see https://status.github.com/api#api-recent-messages
     * 
     * @return array GitHub status messages.
     */
    public function githubStatusMessages()
    {
        $options = array(
            'endpoint' => $this->configuration()->get('status_api_endpoint'),
        );
        
        return $this->request()->get('messages.json', $options);
    }
}
