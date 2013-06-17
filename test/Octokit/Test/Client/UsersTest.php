<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class UsersTest extends \PHPUnit_Framework_TestCase
{
    public $client;
    
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function tearDown()
    {
        $this->client->configuration->reset();
    }
    
    public function request()
    {
        return $this->client->request;
    }
    
    public function users()
    {
        return $this->client->users();
    }
    
    public function testSearchUsers()
    {
        $this->request()->setFixture('legacy/users');
        
        $users = $this->users()->searchUsers('sferik');
        
        $this->assertEquals($users[0]['login'], 'sferik');
    }
    
    public function testAllUsers()
    {
        $this->request()->setFixture('all_users');
        
        $users = $this->users()->allUsers();
        
        $this->assertEquals($users[0]['login'], 'mojombo');
    }
    
    public function testUserWithUsername()
    {
        $this->request()->setFixture('user');
        
        $user = $this->users()->user('sferik');
        
        $this->assertEquals($user['login'], 'sferik');
    }
    
    public function testUserWithoutUsername()
    {
        $this->request()->setFixture('user');
        
        $user = $this->users()->user();
        
        $this->assertEquals($user['login'], 'sferik');
    }
    
    public function testAccessToken()
    {
        $this->request()->setFixture('user_token');
        
        $access_token = $this->users()->accessToken('code', 'id_here', 'secret_here');
        
        $this->assertEquals($access_token['access_token'], 'this_be_ye_token/use_it_wisely');
    }
    
    public function testValidateCredentials()
    {
        $this->request()->setFixture('user');
        
        $valid = $this->users()->validateCredentials(array(
            'login'    => 'sferik',
            'password' => 'foobar',
        ));
        
        $this->assertTrue($valid);
    }
    
    public function testUpdateUser()
    {
        $this->request()->setFixture('user');
        
        $user = $this->users()->updateUser(array(
            'body' => array(
                'name'     => 'Erik Michaels-Ober',
                'email'    => 'sferik@gmail.com',
                'company'  => 'Code for America',
                'location' => 'San Francisco',
                'hireable' => false,
            ),
        ));
        
        $this->assertEquals($user['login'], 'sferik');
    }
    
    public function testFollowersWithUsername()
    {
        $this->request()->setFixture('followers');
        
        $followers = $this->users()->followers('sferik');
        
        $this->assertEquals($followers[0]['login'], 'puls');
    }
    
    public function testFollowersWithoutUsername()
    {
        $this->request()->setFixture('followers');
        
        $followers = $this->users()->followers();
        
        $this->assertEquals($followers[0]['login'], 'puls');
    }
    
    public function testFollowingWithUsername()
    {
        $this->request()->setFixture('following');
        
        $following = $this->users()->following('sferik');
        
        $this->assertEquals($following[0]['login'], 'rails');
    }
    
    public function testFollowingWithoutUsername()
    {
        $this->request()->setFixture('following');
        
        $following = $this->users()->following();
        
        $this->assertEquals($following[0]['login'], 'rails');
    }
    
    public function testFollowsWithMutualFollow()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $follows = $this->users()->follows('sferik', 'puls');
        
        $this->assertTrue($follows);
    }
    
    public function testFollowsWithNotMutualFollow()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        try {
            $follows = $this->users()->follows('sferik', 'dogbrainz');
        } catch (\Octokit\Exception\NotFoundException $e) {
            $follows = false;
        }
        
        $this->assertFalse($follows);
    }
    
    public function testFollow()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $follow = $this->users()->follow('dianakimball');
        
        $this->assertTrue($follow);
    }
    
    public function testUnfollow()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $unfollow = $this->users()->unfollow('dogbrainz');
        
        $this->assertTrue($unfollow);
    }
    
    public function testStarredWithUserStarringRepo()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $starred = $this->users()->stars('sferik', 'rails_admin');
        
        $this->assertTrue($starred);
    }
    
    public function testStarredWithUserNotStarringRepo()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        try {
            $starred = $this->users()->stars('sferik', 'dogbrainz');
         } catch (\Octokit\Exception\NotFoundException $e) {
            $starred = false;
        }
        
        $this->assertFalse($starred);
    }
    
    public function testStarredWithUsername()
    {
        $this->request()->setFixture('starred');
        
        $starred = $this->users()->starred('sferik');
        
        $this->assertEquals($starred[0]['name'], 'grit');
    }
    
    public function testStarredWithoutUsername()
    {
        $this->request()->setFixture('starred');
        
        $starred = $this->users()->starred();
        
        $this->assertEquals($starred[0]['name'], 'grit');
    }
    
    public function testWatchedWithUsername()
    {
        $this->request()->setFixture('watched');
        
        $watched = $this->users()->watched('sferik');
        
        $this->assertEquals($watched[0]['name'], 'grit');
    }
    
    public function testWatchedWithoutUsername()
    {
        $this->request()->setFixture('watched');
        
        $watched = $this->users()->watched();
        
        $this->assertEquals($watched[0]['name'], 'grit');
    }
    
    public function testKey()
    {
        $this->request()->setFixture('public_key');
        
        $public_key = $this->users()->key(103205);
        
        $this->assertEquals($public_key['id'], 103205);
        $this->assertTrue(strpos($public_key['key'], 'ssh-dss AAAAB') !== false);
    }
    
    public function testKeys()
    {
        $this->request()->setFixture('public_keys');
        
        $public_keys = $this->users()->keys();
        
        $this->assertEquals($public_keys[0]['id'], 103205);
    }
    
    public function testUserKeys()
    {
        $this->request()->setFixture('public_keys');
        
        $public_keys = $this->users()->userKeys('pengwynn');
        
        $this->assertEquals($public_keys[0]['id'], 103205);
    }
    
    public function testAddKey()
    {
        $this->request()->setFixture('public_key');
        
        $title = 'Moss';
        $key = 'ssh-dss AAAAB3NzaC1kc3MAAACBAJz7HanBa18ad1YsdFzHO5Wy1/WgXd4BV+czbKq7q23jungbfjN3eo2a0SVdxux8GG+RZ9ia90VD/X+PE4s3LV60oXZ7PDAuyPO1CTF0TaDoKf9mPaHcPa6agMJVocMsgBgwviWT1Q9VgN1SccDsYVDtxkIAwuw25YeHZlG6myx1AAAAFQCgW+OvXWUdUJPBGkRJ8ML7uf0VHQAAAIAlP5G96tTss0SKYVSCJCyocn9cyGQdNjxah4/aYuYFTbLI1rxk7sr/AkZfJNIoF2UFyO5STbbratykIQGUPdUBg1a2t72bu31x+4ZYJMngNsG/AkZ2oqLiH6dJKHD7PFx2oSPalogwsUV7iSMIZIYaPa03A9763iFsN0qJjaed+gAAAIBxz3Prxdzt/os4XGXSMNoWcS03AFC/05NOkoDMrXxQnTTpp1wrOgyRqEnKz15qC5dWk1ynzK+LJXHDZGA8lXPfCjHpJO3zrlZ/ivvLhgPdDpt13MAhIJFH06hTal0woxbk/fIdY71P3kbgXC0Ppx/0S7BC+VxqRCA4/wcM+BoDbA== host';
        
        $public_key = $this->users()->addKey($title, $key);
        
        $this->assertEquals($public_key['id'], 103205);
    }
    
    public function testUpdateKey()
    {
        $this->request()->setFixture('public_key_update');
        
        $title = 'updated title';
        $key = 'ssh-rsa BBBB...';
        
        $updated_key = array(
            'title' => $title,
            'key'   => $key,
        );
        
        $public_key = $this->users()->updateKey(1, $updated_key);
        
        $this->assertEquals($public_key['title'], $title);
        $this->assertEquals($public_key['key'], $key);
    }
    
    public function testRemoveKey()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $public_key = $this->users()->removeKey(103205);
        
        $this->assertTrue($public_key);
    }
    
    public function testEmails()
    {
        $this->request()->setFixture('emails');
        
        $emails = $this->users()->emails();
        
        $this->assertEquals($emails[0], 'sferik@gmail.com');
    }
    
    public function testAddEmail()
    {
        $this->request()->setFixture('emails');
        
        $emails = $this->users()->addEmail('sferik@gmail.com');
        
        $this->assertEquals($emails[0], 'sferik@gmail.com');
    }
    
    public function testRemoveEmail()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $email = $this->users()->removeEmail('sferik@gmail.com');
        
        $this->assertTrue($email);
    }
    
    public function testSubscriptions()
    {
        $this->request()->setFixture('subscriptions');
        
        $subscriptions = $this->users()->subscriptions('pengwynn');
        
        $this->assertEquals($subscriptions[0]['id'], 11560);
        $this->assertEquals($subscriptions[0]['name'], 'ujs_sort_helper');
    }
}
