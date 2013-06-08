<?php

namespace Octokit\Test\Client;

use Octokit\Client;
use Octokit\Client\Users;

class UsersTest extends \PHPUnit_Framework_TestCase
{
    public $client;
    
    public function setUp()
    {
        $this->client = new Client();
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
        $this->request()->set_fixture('legacy/users');
        
        $users = $this->users()->search_users('sferik');
        
        $this->assertEquals($users[0]['login'], 'sferik');
    }
    
    public function testAllUsers()
    {
        $this->request()->set_fixture('all_users');
        
        $users = $this->users()->all_users();
        
        $this->assertEquals($users[0]['login'], 'mojombo');
    }
    
    public function testUserWithUsername()
    {
        $this->request()->set_fixture('user');
        
        $user = $this->users()->user('sferik');
        
        $this->assertEquals($user['login'], 'sferik');
    }
    
    public function testUserWithoutUsername()
    {
        $this->request()->set_fixture('user');
        
        $user = $this->users()->user();
        
        $this->assertEquals($user['login'], 'sferik');
    }
    
    public function testAccessToken()
    {
        $this->request()->set_fixture('user_token');
        
        $access_token = $this->users()->access_token('code', 'id_here', 'secret_here');
        
        $this->assertEquals($access_token['access_token'], 'this_be_ye_token/use_it_wisely');
    }
    
    public function testValidateCredentials()
    {
        $this->request()->set_fixture('user');
        
        $valid = $this->users()->validate_credentials(array(
            'login'    => 'sferik',
            'password' => 'foobar',
        ));
        
        $this->assertTrue($valid);
    }
    
    public function testUpdateUser()
    {
        $this->request()->set_fixture('user');
        
        $user = $this->users()->update_user(array(
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
        $this->request()->set_fixture('followers');
        
        $followers = $this->users()->followers('sferik');
        
        $this->assertEquals($followers[0]['login'], 'puls');
    }
    
    public function testFollowersWithoutUsername()
    {
        $this->request()->set_fixture('followers');
        
        $followers = $this->users()->followers();
        
        $this->assertEquals($followers[0]['login'], 'puls');
    }
    
    public function testFollowingWithUsername()
    {
        $this->request()->set_fixture('following');
        
        $following = $this->users()->following('sferik');
        
        $this->assertEquals($following[0]['login'], 'rails');
    }
    
    public function testFollowingWithoutUsername()
    {
        $this->request()->set_fixture('following');
        
        $following = $this->users()->following();
        
        $this->assertEquals($following[0]['login'], 'rails');
    }
    
    public function testFollowsWithMutualFollow()
    {
        $this->request()->set_fixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $follows = $this->users()->follows('sferik', 'puls');
        
        $this->assertTrue($follows);
    }
    
    public function testFollowsWithNotMutualFollow()
    {
        $this->request()->set_fixture(array(
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
        $this->request()->set_fixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $follow = $this->users()->follow('dianakimball');
        
        $this->assertTrue($follow);
    }
    
    public function testUnfollow()
    {
        $this->request()->set_fixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $unfollow = $this->users()->unfollow('dogbrainz');
        
        $this->assertTrue($unfollow);
    }
    
    public function testStarredWithUserStarringRepo()
    {
        $this->request()->set_fixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $starred = $this->users()->stars('sferik', 'rails_admin');
        
        $this->assertTrue($starred);
    }
    
    public function testStarredWithUserNotStarringRepo()
    {
        $this->request()->set_fixture(array(
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
        $this->request()->set_fixture('starred');
        
        $starred = $this->users()->starred('sferik');
        
        $this->assertEquals($starred[0]['name'], 'grit');
    }
    
    public function testStarredWithoutUsername()
    {
        $this->request()->set_fixture('starred');
        
        $starred = $this->users()->starred();
        
        $this->assertEquals($starred[0]['name'], 'grit');
    }
    
    public function testWatchedWithUsername()
    {
        $this->request()->set_fixture('watched');
        
        $watched = $this->users()->watched('sferik');
        
        $this->assertEquals($watched[0]['name'], 'grit');
    }
    
    public function testWatchedWithoutUsername()
    {
        $this->request()->set_fixture('watched');
        
        $watched = $this->users()->watched();
        
        $this->assertEquals($watched[0]['name'], 'grit');
    }
    
    public function testKey()
    {
        $this->request()->set_fixture('public_key');
        
        $public_key = $this->users()->key(103205);
        
        $this->assertEquals($public_key['id'], 103205);
        $this->assertTrue(strpos($public_key['key'], 'ssh-dss AAAAB') !== false);
    }
    
    public function testKeys()
    {
        $this->request()->set_fixture('public_keys');
        
        $public_keys = $this->users()->keys();
        
        $this->assertEquals($public_keys[0]['id'], 103205);
    }
    
    public function testUserKeys()
    {
        $this->request()->set_fixture('public_keys');
        
        $public_keys = $this->users()->user_keys('pengwynn');
        
        $this->assertEquals($public_keys[0]['id'], 103205);
    }
    
    public function testAddKey()
    {
        $this->request()->set_fixture('public_key');
        
        $title = 'Moss';
        $key = 'ssh-dss AAAAB3NzaC1kc3MAAACBAJz7HanBa18ad1YsdFzHO5Wy1/WgXd4BV+czbKq7q23jungbfjN3eo2a0SVdxux8GG+RZ9ia90VD/X+PE4s3LV60oXZ7PDAuyPO1CTF0TaDoKf9mPaHcPa6agMJVocMsgBgwviWT1Q9VgN1SccDsYVDtxkIAwuw25YeHZlG6myx1AAAAFQCgW+OvXWUdUJPBGkRJ8ML7uf0VHQAAAIAlP5G96tTss0SKYVSCJCyocn9cyGQdNjxah4/aYuYFTbLI1rxk7sr/AkZfJNIoF2UFyO5STbbratykIQGUPdUBg1a2t72bu31x+4ZYJMngNsG/AkZ2oqLiH6dJKHD7PFx2oSPalogwsUV7iSMIZIYaPa03A9763iFsN0qJjaed+gAAAIBxz3Prxdzt/os4XGXSMNoWcS03AFC/05NOkoDMrXxQnTTpp1wrOgyRqEnKz15qC5dWk1ynzK+LJXHDZGA8lXPfCjHpJO3zrlZ/ivvLhgPdDpt13MAhIJFH06hTal0woxbk/fIdY71P3kbgXC0Ppx/0S7BC+VxqRCA4/wcM+BoDbA== host';
        
        $public_key = $this->users()->add_key($title, $key);
        
        $this->assertEquals($public_key['id'], 103205);
    }
    
    public function testUpdateKey()
    {
        $this->request()->set_fixture('public_key_update');
        
        $title = 'updated title';
        $key = 'ssh-rsa BBBB...';
        
        $updated_key = array(
            'title' => $title,
            'key'   => $key,
        );
        
        $public_key = $this->users()->update_key(1, $updated_key);
        
        $this->assertEquals($public_key['title'], $title);
        $this->assertEquals($public_key['key'], $key);
    }
    
    public function testRemoveKey()
    {
        $this->request()->set_fixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $public_key = $this->users()->remove_key(103205);
        
        $this->assertTrue($public_key);
    }
    
    public function testEmails()
    {
        $this->request()->set_fixture('emails');
        
        $emails = $this->users()->emails();
        
        $this->assertEquals($emails[0], 'sferik@gmail.com');
    }
    
    public function testAddEmail()
    {
        $this->request()->set_fixture('emails');
        
        $emails = $this->users()->add_email('sferik@gmail.com');
        
        $this->assertEquals($emails[0], 'sferik@gmail.com');
    }
    
    public function testRemoveEmail()
    {
        $this->request()->set_fixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $email = $this->users()->remove_email('sferik@gmail.com');
        
        $this->assertTrue($email);
    }
    
    public function testSubscriptions()
    {
        $this->request()->set_fixture('subscriptions');
        
        $subscriptions = $this->users()->subscriptions('pengwynn');
        
        $this->assertEquals($subscriptions[0]['id'], 11560);
        $this->assertEquals($subscriptions[0]['name'], 'ujs_sort_helper');
    }
}
