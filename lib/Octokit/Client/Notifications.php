<?php

namespace Octokit\Client;

use Octokit\Api;

class Notifications extends Api
{
    public $aliases = array(
        'repoNotifications'           => 'repositoryNotifications',
        'markRepoNotificationsAsRead' => 'markRepositoryNotificationsAsRead',
    );
    
    /**
     * List your notifications.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#list-your-notifications
     *
     * @param array $options Optional options.
     *
     * @return array Array of notifications.
     */
    public function notifications(array $options = array())
    {
        return $this->request()->get('notifications', $options);
    }
    
    /**
     * List your notifications in a repository.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#list-your-notifications-in-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of notifications.
     */
    public function repositoryNotifications($repo, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/notifications', $options);
    }
    
    /**
     * Mark notifications as read.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#mark-as-read
     *
     * @param array $options Optional options.
     *
     * @return bool True if marked as read, false otherwise.
     */
    public function markNotificationsAsRead(array $options = array())
    {
        try {
            $response = $this->request()->sendRequest('put', 'notifications', $options);
        } catch (\Exception $e) {
            return false;
        }
        
        return $response->getStatusCode() == 205;
    }
    
    /**
     * Mark notifications from a specific repository as read.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#mark-notifications-as-read-in-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool True if marked as read, false otherwise.
     */
    public function markRepositoryNotificationsAsRead($repo, array $options = array())
    {
        try {
            $response = $this->request()->sendRequest('put', 'repos/' . $repo . '/notifications', $options);
        } catch (\Exception $e) {
            return false;
        }
        
        return $response->getStatusCode() == 205;
    }
    
    /**
     * List notifications for a specific thread.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#view-a-single-thread
     *
     * @param int   $thread_id Id of the thread.
     * @param array $options   Optional options.
     *
     * @return array Array of notifications.
     */
    public function threadNotifications($thread_id, array $options = array())
    {
        return $this->request()->get('notifications/threads/' . $thread_id, $options);
    }
    
    /**
     * Mark thread as read.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#mark-a-thread-as-read
     *
     * @param int   $thread_id Id of the thread to update.
     * @param array $options   Optional options.
     *
     * @return bool True if updated, false otherwise.
     */
    public function markThreadAsRead($thread_id, array $options = array())
    {
        try {
            $response = $this->request()->sendRequest('patch', 'notifications/threads/' . $thread_id, $options);
        } catch (\Exception $e) {
            return false;
        }
        
        return $response->getStatusCode() == 205;
    }
    
    /**
     * Get thread subscription.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#get-a-thread-subscription
     *
     * @param int   $thread_id Id of the thread.
     * @param array $options   Optional options.
     *
     * @return array Subscription.
     */
    public function threadSubscription($thread_id, array $options = array())
    {
        return $this->request()->get('notifications/threads/' . $thread_id . '/subscription', $options);
    }
    
    /**
     * Update thread subscription.
     * 
     * This lets you subscribe to a thread, or ignore it. Subscribing to a
     * thread is unnecessary if the user is already subscribed to the
     * repository. Ignoring a thread will mute all future notifications (until
     * you comment or get @mentioned).
     * 
     * @see http://developer.github.com/v3/activity/notifications/#set-a-thread-subscription
     *
     * @param int   $thread_id Id of the thread.
     * @param array $options   Optional options.
     *
     * @return array Updated subscription.
     */
    public function updateThreadSubscription($thread_id, array $options = array())
    {
        return $this->request()->put('notifications/threads/' . $thread_id . '/subscription', $options);
    }
    
    /**
     * Delete a thread subscription.
     * 
     * @see http://developer.github.com/v3/activity/notifications/#delete-a-thread-subscription
     *
     * @param int   $thread_id Id of the thread.
     * @param array $options   Optional options.
     *
     * @return bool True if delete successful, false otherwise.
     */
    public function deleteThreadSubscription($thread_id, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'notifications/threads/' . $thread_id, $options);
    }
}
