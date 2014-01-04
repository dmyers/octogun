<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class EventsTest extends \Octokit\Test\OctokitTestCase
{
    public $client;
    
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function events()
    {
        return $this->client->events();
    }
    
    public function testPublicEvents()
    {
        $this->request()->setFixture('public_events');
        
        $public_events = $this->events()->publicEvents();
        
        $this->assertEquals($public_events[0]['id'], 1513284759);
    }
    
    public function testUserEvents()
    {
        $this->request()->setFixture('user_events');
        
        $user_events = $this->events()->userEvents('sferik');
        
        $this->assertEquals($user_events[0]['id'], 1525888969);
    }
    
    public function testUserPublicEvents()
    {
        $this->request()->setFixture('user_performed_public_events');
        
        $user_public_events = $this->events()->userPublicEvents('sferik');
        
        $this->assertEquals($user_public_events[0]['id'], 1652715007);
    }
    
    public function testReceivedEvents()
    {
        $this->request()->setFixture('user_events');
        
        $received_events = $this->events()->receivedEvents('sferik');
        
        $this->assertEquals($received_events[0]['type'], 'PushEvent');
    }
    
    public function testReceivedPublicEvents()
    {
        $this->request()->setFixture('user_public_events');
        
        $received_public_events = $this->events()->receivedPublicEvents('sferik');
        
        $this->assertEquals($received_public_events[0]['id'], 1652756065);
    }
    
    public function testRepositoryEvents()
    {
        $this->request()->setFixture('repo_events');
        
        $repo_events = $this->events()->repositoryEvents('sferik/rails_admin');
        
        $this->assertEquals($repo_events[0]['type'], 'IssuesEvent');
    }
    
    public function testRepositoryNetworkEvents()
    {
        $this->request()->setFixture('repository_network_events');
        
        $repo_network_events = $this->events()->repositoryNetworkEvents('sferik/rails_admin');
        
        $this->assertEquals($repo_network_events[0]['id'], 1651989733);
    }
    
    public function testOrganizationEvents()
    {
        $this->request()->setFixture('organization_events');
        
        $org_events = $this->events()->organizationEvents('lostisland');
        
        $this->assertEquals($org_events[0]['id'], 1652750175);
    }
    
    public function testOrganizationPublicEvents()
    {
        $this->request()->setFixture('organization_public_events');
        
        $org_public_events = $this->events()->organizationPublicEvents('github');
        
        $this->assertEquals($org_public_events[0]['id'], 1652750175);
    }
}
