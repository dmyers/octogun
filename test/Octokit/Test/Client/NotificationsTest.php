<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class NotificationsTest extends \Octokit\Test\OctokitTestCase
{
    public $client;
    
    public function setUp()
    {
        $this->client = new Client(array('login' => 'joeyw'));
    }
    
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function notifications()
    {
        return $this->client->notifications();
    }
    
    public function testNotifications()
    {
        $this->request()->setFixture('notifications');
        
        $notifications = $this->notifications()->notifications();
        
        $this->assertEquals($notifications[0]['id'], 1);
        $this->assertEquals($notifications[0]['unread'], true);
    }
    
    public function testRepositoryNotifications()
    {
        $this->request()->setFixture('repository_notifications');
        
        $notifications = $this->notifications()->repositoryNotifications('pengwynn/octokit');
        
        $this->assertEquals($notifications[0]['id'], 1);
        $this->assertEquals($notifications[0]['unread'], true);
    }
    
    public function testMarkNotificationsAsReadSuccess()
    {
        $this->request()->setFixture(array(
            'status' => 205,
            'body'   => '',
        ));
        
        $result = $this->notifications()->markNotificationsAsRead();
        
        $this->assertTrue($result);
    }
    
    public function testMarkNotificationsAsReadFailure()
    {
        $this->request()->setFixture(array(
            'status' => 500,
            'body'   => '',
        ));
        
        $result = $this->notifications()->markNotificationsAsRead();
        
        $this->assertFalse($result);
    }
    
    public function testMarkRepositoryNotificationsAsReadSuccess()
    {
        $this->request()->setFixture(array(
            'status' => 205,
            'body'   => '',
        ));
        
        $result = $this->notifications()->markRepositoryNotificationsAsRead('pengwynn/octokit');
        
        $this->assertTrue($result);
    }
    
    public function testMarkRepositoryNotificationsAsReadFailure()
    {
        $this->request()->setFixture(array(
            'status' => 500,
            'body'   => '',
        ));
        
        $result = $this->notifications()->markRepositoryNotificationsAsRead('pengwynn/octokit');
        
        $this->assertFalse($result);
    }
    
    public function testThreadNotifications()
    {
        $this->request()->setFixture('notification_thread');
        
        $notifications = $this->notifications()->threadNotifications(1);
        
        $this->assertEquals($notifications[0]['id'], 1);
        $this->assertEquals($notifications[0]['unread'], true);
    }
    
    public function testMarkThreadNotificationsAsReadSuccess()
    {
        $this->request()->setFixture(array(
            'status' => 205,
            'body'   => '',
        ));
        
        $result = $this->notifications()->markThreadAsRead(1);
        
        $this->assertTrue($result);
    }
    
    public function testMarkThreadNotificationsAsReadFailure()
    {
        $this->request()->setFixture(array(
            'status' => 500,
            'body'   => '',
        ));
        
        $result = $this->notifications()->markThreadAsRead(1);
        
        $this->assertFalse($result);
    }
    
    public function testThreadSubscription()
    {
        $this->request()->setFixture('thread_subscription');
        
        $subscription = $this->notifications()->threadSubscription(1);
        
        $this->assertTrue($subscription['subscribed']);
    }
    
    public function testUpdateThreadSubscription()
    {
        $this->request()->setFixture('thread_subscription_update');
        
        $subscription = $this->notifications()->updateThreadSubscription(1, array(
            'subscribed' => true,
        ));
        
        $this->assertTrue($subscription['subscribed']);
    }
    
    public function testDeleteThreadSubscriptionSuccess()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->notifications()->deleteThreadSubscription(1);
        
        $this->assertTrue($result);
    }
    
    public function testDeleteThreadSubscriptionFailure()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        $result = $this->notifications()->deleteThreadSubscription(1);
        
        $this->assertFalse($result);
    }
}
