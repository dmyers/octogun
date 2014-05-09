<?php

namespace Octogun\Client;

use Octogun\Api;

class Events extends Api
{
    /**
     * List all public events for GitHub.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-public-events
     * 
     * @param array $options Optional options.
     * 
     * @return array A list of all public events from GitHub.
     */
    public function publicEvents(array $options = array())
    {
        return $this->request()->get('events', $options);
    }
    
    /**
     * List all user events.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-events-performed-by-a-user
     * 
     * @param string $user    GitHub username.
     * @param array  $options Optional options.
     * 
     * @return array A list of all user events.
     */
    public function userEvents($user, array $options = array())
    {
        return $this->request()->get('users/' . $user . '/events', $options);
    }
    
    /**
     * List public user events.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-public-events-performed-by-a-user
     * 
     * @param string $user    GitHub username.
     * @param array  $options Optional options.
     * 
     * @return array A list of public user events.
     */
    public function userPublicEvents($user, array $options = array())
    {
        return $this->request()->get('users/' . $user . '/events/public', $options);
    }
    
    /**
     * List events that a user has received.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-events-that-a-user-has-received
     * 
     * @param string $user    GitHub username.
     * @param array  $options Optional options.
     * 
     * @return array A list of all user received events.
     */
    public function receivedEvents($user, array $options = array())
    {
        return $this->request()->get('users/' . $user . '/received_events', $options);
    }
    
    /**
     * List public events a user has received.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-public-events-that-a-user-has-received
     * 
     * @param string $user    GitHub username.
     * @param array  $options Optional options.
     * 
     * @return array A list of public user received events.
     */
    public function receivedPublicEvents($user, array $options = array())
    {
        return $this->request()->get('users/' . $user . '/received_events/public', $options);
    }
    
    /**
     * List events for a repository.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-repository-events
     * 
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return array A list of events for a repository.
     */
    public function repositoryEvents($repo, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/events', $options);
    }
    
    /**
     * List public events for a repository's network.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-public-events-for-a-network-of-repositories
     * 
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return array A list of events for a repository's network.
     */
    public function repositoryNetworkEvents($repo, array $options = array())
    {
        return $this->request()->get('networks/' . $repo . '/events', $options);
    }
    
    /**
     * List all events for an organization.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-events-for-an-organization
     * 
     * @param string $org     Organization GitHub handle.
     * @param array  $options Optional options.
     * 
     * @return array List of all events from a GitHub organization.
     */
    public function organizationEvents($org, array $options = array())
    {
        $login = $this->configuration()->get('login');
        
        return $this->request()->get('users/' . $login . '/events/orgs/' . $org, $options);
    }
    
    /**
     * List an organization's public events.
     * 
     * @see http://developer.github.com/v3/activity/events/#list-public-events-for-an-organization
     * 
     * @param string $org     Organization GitHub handle.
     * @param array  $options Optional options.
     * 
     * @return array List of public events from a GitHub organization.
     */
    public function organizationPublicEvents($org, array $options = array())
    {
        return $this->request()->get('orgs/' . $org . '/events', $options);
    }
}
