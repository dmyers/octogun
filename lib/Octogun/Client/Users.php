<?php

namespace Octogun\Client;

use Octogun\Api;
use Octogun\Client;

class Users extends Api
{
    /**
     * Search for user.
     * 
     * @see http://developer.github.com/v3/search/#search-users
     *
     * @param string $search  User to search for.
     * @param array  $options Optional options.
     *
     * @return array List of matching users.
     */
    public function searchUsers($search, array $options = array())
    {
        $users = $this->request()->get('legacy/user/search/' . $search, $options);
        
        return $users['users'];
    }
    
    /**
     * List all GitHub users.
     * 
     * @see http://developer.github.com/v3/users/#get-all-users
     *
     * @param array $options Optional options.
     *
     * @return array List of GitHub users.
     */
    public function allUsers(array $options = array())
    {
        return $this->request()->get('users', $options);
    }
    
    /**
     * Get a single user.
     * 
     * @see http://developer.github.com/v3/users/#get-a-single-user
     *
     * @param string $user    A GitHub user name.
     * @param array  $options Optional options.
     *
     * @return array
     */
    public function user($user = null, array $options = array())
    {
        if (!empty($user)) {
            return $this->request()->get('users/' . $user, $options);
        }
        else {
            return $this->request()->get('user', $options);
        }
    }
    
    /**
     * Retrieve the access_token.
     * 
     * @see http://developer.github.com/v3/oauth/#web-application-flow
     *
     * @param string $code       Authorization code generated by GitHub.
     * @param string $app_id     Client Id we received when our application was registered with GitHub.
     * @param string $app_secret Client Secret we received when our application was registered with GitHub.
     * @param array  $options    Optional options.
     *
     * @return array Array holding the access token.
     */
    public function accessToken($code, $app_id = null, $app_secret = null, array $options = array())
    {
        if (empty($app_id)) {
            $app_id = $this->configuration()->get('client_id');
        }
        
        if (empty($app_secret)) {
            $app_secret = $this->configuration()->get('client_secret');
        }
        
        $options = array_merge(array(
            'endpoint'      => $this->configuration()->get('web_endpoint'),
            'code'          => $code,
            'client_id'     => $app_id,
            'client_secret' => $app_secret,
            'accept'        => 'application/json',
        ), $options);
        
        return $this->request()->post('login/oauth/access_token', $options);
    }
    
    /**
     * Validate user username and password.
     *
     * @param array $options User credentials.
     * 
     * @return bool True if credentials are valid.
     */
    public function validateCredentials(array $options = array())
    {
        $this->configuration()->reset();
        
        $this->configuration()->set($options);
        
        try {
            $user = $this->user();
        } catch (\Octogun\Exception\UnauthorizedException $e) {
            return false;
        }
        
        if (empty($user)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Update the authenticated user.
     *
     * @param array $options A customizable set of options.
     *
     * @return array
     */
    public function updateUser(array $options = array())
    {
        return $this->request()->patch('user', $options);
    }
    
    /**
     * Get a user's followers.
     * 
     * @see http://developer.github.com/v3/users/followers/#list-followers-of-a-user
     *
     * @param string $user    Username of the user whose list of followers you are getting.
     * @param array  $options Optional options.
     *
     * @return array List of representing users followers.
     */
    public function followers($user = null, array $options = array())
    {
        if (empty($user)) {
            $user = $this->configuration()->get('login');
        }
        
        return $this->request()->get('users/'. $user . '/followers', $options);
    }
    
    /**
     * Get list of users a user is following.
     * 
     * @see http://developer.github.com/v3/users/followers/#list-users-following-another-user
     *
     * @param string $user    Username of the user who you are getting the list of the people they follow.
     * @param array  $options Optional options.
     *
     * @return array List of representing users a user is following.
     */
    public function following($user = null, array $options = array())
    {
        if (empty($user)) {
            $user = $this->configuration()->get('login');
        }
        
        return $this->request()->get('users/'. $user . '/following', $options);
    }
    
    /**
     * Check if you are following a user.
     * 
     * Requries an authenticated client.
     * 
     * @see http://developer.github.com/v3/users/followers/#check-if-you-are-following-a-user
     *
     * @param string $user Username of the user that you want to check if you are following.
     *
     * @return bool True if you are following the user, false otherwise.
     */
    public function follows()
    {
        $args = func_get_args();
        
        $target = $args[0];
        
        if (empty($args[1])) {
            $user = $this->configuration()->get('login');
        }
        else {
            $user = $args[1];
        }
        
        return $this->request()->booleanFromResponse('get', 'user/following/' . $target);
    }
    
    /**
     * Follow a user.
     * 
     * Requires authenticatied client.
     * 
     * @see http://developer.github.com/v3/users/followers/#follow-a-user
     *
     * @param string $user    Username of the user to follow.
     * @param array  $options Optional options.
     *
     * @return bool True if follow was successful, false otherwise.
     */
    public function follow($user, array $options = array())
    {
        return $this->request()->booleanFromResponse('put', 'user/following/' . $user, $options);
    }
    
    /**
     * Unfollow a user.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/followers/#unfollow-a-user
     *
     * @param string $user    Username of the user to unfollow.
     * @param array  $options Optional options.
     *
     * @return bool True if unfollow was successful, false otherwise.
     */
    public function unfollow($user, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'user/following/' . $user, $options);
    }
    
    /**
     * Get list of repos starred by a user.
     * 
     * @see http://developer.github.com/v3/repos/starring/#list-repositories-being-starred
     * 
     * @param string $user    Username of the user to get the list of their starred repositories.
     * @param array  $options Optional options.
     *
     * @return array List of representing repositories starred by user.
     */
    public function starred($user = null, array $options = array())
    {
        if (empty($user)) {
            $user = $this->configuration()->get('login');
        }
        
        return $this->request()->get('users/' . $user . '/starred', $options);
    }
    
    /**
     * Check if you are starring a repo.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/starring/#check-if-you-are-starring-a-repository
     *
     * @param string $user    Username of repository owner.
     * @param string $repo    Name of the repository.
     * @param array  $options Optional options.
     *
     * @return bool True if you are following the repo, false otherwise.
     */
    public function stars($user, $repo, array $options = array())
    {
        return $this->request()->booleanFromResponse('get', 'user/starred/' . $user . '/' . $repo, $options);
    }
    
    /**
     * Get list of repos watched by a user.
     * 
     * Legacy, using github.beta media type. Use `Users#starred` instead.
     * 
     * @see http://developer.github.com/v3/repos/starring/#list-stargazers
     * 
     * @param string $user    Username of the user to get the list of repositories they are watching.
     * @param array  $options Optional options.
     *
     * @return array List of representing repositories watched by user.
     */
    public function watched($user = null, array $options = array())
    {
        if (empty($user)) {
            $user = $this->configuration()->get('login');
        }
        
        return $this->request()->get('users/' . $user . '/watched', $options);
    }
    
    /**
     * Get a public key.
     * 
     * Note, when using dot notation to retrieve the values, ruby will return
     * the hash key for the public keys value instead of the actual value, use
     * symbol or key string to retrieve the value. See example.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/keys/#get-a-single-public-key
     *
     * @param int   $key_id  Key to retreive.
     * @param array $options Optional options.
     *
     * @return array Array representing the key.
     */
    public function key($key_id, array $options = array())
    {
        return $this->request()->get('user/keys/' . $key_id, $options);
    }
    
    /**
     * Get list of public keys for user.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/keys/#list-your-public-keys
     *
     * @param array $options Optional options.
     *
     * @return array List of representing public keys.
     */
    public function keys(array $options = array())
    {
        return $this->request()->get('user/keys', $options);
    }
    
    /**
     * Get list of public keys for user.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/keys/#list-public-keys-for-a-user
     * 
     * @param string $user    Username of the user to get the list of keys.
     * @param array  $options Optional options.
     *
     * @return array List of representing public keys.
     */
    public function userKeys($user, array $options = array())
    {
        return $this->request()->get('users/' . $user . '/keys', $options);
    }
    
    /**
     * Add public key to user account.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/keys/#create-a-public-key
     *
     * @param string $title   Title to give reference to the public key.
     * @param string $key     Public key.
     * @param array  $options Optional options.
     * 
     * @return array Array representing the newly added public key.
     */
    public function addKey($title, $key, array $options = array())
    {
        $options = array_merge(array(
            'title' => $title,
            'key'   => $key,
        ), $options);
        
        return $this->request()->post('user/keys', $options);
    }
    
    /**
     * Update a public key.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/keys/#update-a-public-key
     *
     * @param int   $key_id  Id of key to update.
     * @param array $options Optional options.
     *
     * @return array Array representing the updated public key.
     */
    public function updateKey($key_id, array $options = array())
    {
        return $this->request()->patch('user/keys/' . $key_id, $options);
    }
    
    /**
     * Remove a public key from user account.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/keys/#delete-a-public-key
     *
     * @param int   $id      Id of the public key to remove.
     * @param array $options Optional options.
     *
     * @return bool True if removal was successful, false otherwise.
     */
    public function removeKey($id, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'user/keys/' . $id, $options);
    }
    
    /**
     * List email addresses for a user.
     * 
     * Requires authenticated client.
     *
     * @param array $options Optional options.
     *
     * @return array List of email addresses.
     */
    public function emails(array $options = array())
    {
        return $this->request()->get('user/emails', $options);
    }
    
    /**
     * Add email address to user.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/emails/#add-email-addresses
     *
     * @param string $email   Email address to add to the user.
     * @param array  $options Optional options.
     * 
     * @return array List of all email addresses of the user.
     */
    public function addEmail($email, array $options = array())
    {
        $options = array_merge(array(
            'email' => $email,
        ), $options);
        
        return $this->request()->post('user/emails', $options);
    }
    
    /**
     * Remove email from user.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/users/emails/#delete-email-addresses
     *
     * @param string $email   Email address to remove.
     * @param array  $options Optional options.
     *
     * @return bool True if removal was successful, false otherwise.
     */
    public function removeEmail($email, array $options = array())
    {
        $options = array_merge(array(
            'email' => $email,
        ), $options);
        
        return $this->request()->booleanFromResponse('delete', 'user/emails', $options);
    }
    
    /**
     * List repositories being watched by a user.
     * 
     * @see http://developer.github.com/v3/activity/watching/#list-repositories-being-watched
     *
     * @param string $user    User's GitHub username.
     * @param array  $options Optional options.
     *
     * @return array List of repositories.
     */
    public function subscriptions($user = null, array $options = array())
    {
        if (empty($user)) {
            $user = $this->configuration()->get('login');
        }
        
        return $this->request()->get('users/' . $user . '/subscriptions', $options);
    }
}
