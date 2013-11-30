<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class AuthorizationsTest extends \PHPUnit_Framework_TestCase
{
    public $client;
    
    public function setUp()
    {
        $this->client = new Client(array('login' => 'ctshryock', 'password' => 'secret'));
    }
    
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function configuration()
    {
        return $this->client->configuration();
    }
    
    public function request()
    {
        return $this->client->request();
    }
    
    public function authorizations()
    {
        return $this->client->authorizations();
    }
    
    public function testListAuthorizations()
    {
        $this->request()->setFixture('authorizations');
        
        $authorizations = $this->authorizations()->authorizations();
        
        $this->assertEquals($authorizations[0]['app']['name'], 'Calendar About Nothing');
    }
    
    public function testSingleAuthorizations()
    {
        $this->request()->setFixture('authorization');
        
        $authorization = $this->authorizations()->authorization(999999);
        
        $this->assertEquals($authorization['app']['name'], 'Travis');
    }
    
    public function testCreateDefaultAuthorization()
    {
        $this->request()->setFixture('authorization');
        
        $authorization = $this->authorizations()->createAuthorization();
        
        $this->assertEquals($authorization['app']['name'], 'Travis');
    }
    
    public function testCreateAuthorizationWithOptions()
    {
        $this->request()->setFixture('authorization');
        
        $options = array(
            'scopes'   => array('public_repo'),
            'note'     => 'admin script',
            'note_url' => 'https://github.com/pengwynn/octokit',
        );
        
        $authorization = $this->authorizations()->createAuthorization($options);
        
        $this->assertTrue(in_array('public_repo', $authorization['scopes']));
    }
    
    public function updateExistingAuthorization()
    {
        $this->request()->setFixture('authorization');
        
        $options = array('add_scopes' => array('public_repo', 'gist'));
        
        $authorization = $this->authorizations()->updateAuthorization(999999, $options);
        
        $this->assertTrue(in_array('public_repo', $authorization['scopes']));
    }
    
    public function deleteExistingAuthorization()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $delete = $this->authorizations()->deleteAuthorization(999999);
        
        $this->assertTrue($delete);
    }
    
    public function testAuthorizeUrl()
    {
        $this->configuration()->set('client_id', 'id_here');
        
        $url = $this->authorizations()->authorizeUrl();
        
        $this->assertEquals($url, 'https://github.com/login/oauth/authorize?client_id=id_here');
    }
}
