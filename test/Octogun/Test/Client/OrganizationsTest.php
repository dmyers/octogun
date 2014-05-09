<?php

namespace Octogun\Test\Client;

use Octogun\Client;

class OrganizationsTest extends \Octogun\Test\OctogunTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function organizations()
    {
        return $this->client->organizations();
    }
    
    public function testOrganization()
    {
        $this->request()->setFixture('organization');
        
        $organization = $this->organizations()->organization('codeforamerica');
        
        $this->assertEquals($organization['name'], 'Code For America');
    }
    
    public function testUpdateOrganization()
    {
        $this->request()->setFixture('organization');
        
        $organization = $this->organizations()->updateOrganization('codeforamerica', array(
            'name' => 'Code For America',
        ));
        
        $this->assertEquals($organization['name'], 'Code For America');
    }
    
    public function testOrganizationsWithUser()
    {
        $this->request()->setFixture('organizations');
        
        $organizations = $this->organizations()->organizations('sferik');
        
        $this->assertEquals($organizations[0]['login'], 'Hubcap');
    }
    
    public function testOrganizationsWithoutUser()
    {
        $this->request()->setFixture('organizations');
        
        $organizations = $this->organizations()->organizations();
        
        $this->assertEquals($organizations[0]['login'], 'Hubcap');
    }
    
    public function testOrganizationRepositories()
    {
        $this->request()->setFixture('organization-repositories');
        
        $repositories = $this->organizations()->organizationRepositories('codeforamerica');
        
        $this->assertEquals($repositories[0]['name'], 'cfahelloworld');
    }
    
    public function testOrganizationMembers()
    {
        $this->request()->setFixture('organization_members');
        
        $users = $this->organizations()->organizationMembers('codeforamerica');
        
        $this->assertEquals($users[0]['login'], 'akit');
    }
    
    public function testOrganizationMemberWithMember()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $is_hubbernaut = $this->organizations()->organizationMember('github', 'pengwynn');
        
        $this->assertTrue($is_hubbernaut);
    }
    
    public function testOrganizationMemberWithoutMember()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        $is_hubbernaut = $this->organizations()->organizationMember('github', 'joeyw');
        
        $this->assertFalse($is_hubbernaut);
    }
    
    public function testOrganizationPublicMemberWithMember()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $is_hubbernaut = $this->organizations()->organizationPublicMember('github', 'pengwynn');
        
        $this->assertTrue($is_hubbernaut);
    }
    
    public function testOrganizationPublicMemberWithoutMember()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        $is_hubbernaut = $this->organizations()->organizationPublicMember('github', 'joeyw');
        
        $this->assertFalse($is_hubbernaut);
    }
    
    public function testOrganizationTeams()
    {
        $this->request()->setFixture('teams');
        
        $teams = $this->organizations()->organizationTeams('codeforamerica');
        
        $this->assertEquals($teams[0]['name'], 'Fellows');
    }
    
    public function testCreateTeam()
    {
        $this->request()->setFixture('team');
        
        $team = $this->organizations()->createTeam('codeforamerica', array(
            'name' => 'Fellows',
        ));
        
        $this->assertEquals($team['name'], 'Fellows');
    }
    
    public function testTeam()
    {
        $this->request()->setFixture('team');
        
        $team = $this->organizations()->team(32598);
        
        $this->assertEquals($team['name'], 'Fellows');
    }
    
    public function testUpdateTeam()
    {
        $this->request()->setFixture('team');
        
        $team = $this->organizations()->updateTeam(32598, array(
            'name' => 'Fellows',
        ));
        
        $this->assertEquals($team['name'], 'Fellows');
    }
    
    public function testDeleteTeam()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->deleteTeam(32598);
        
        $this->assertTrue($result);
    }
    
    public function testTeamMembers()
    {
        $this->request()->setFixture('organization_team_members');
        
        $users = $this->organizations()->teamMembers(33239);
        
        $this->assertEquals($users[0]['login'], 'ctshryock');
    }
    
    public function testAddTeamMember()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->addTeamMember(32598, 'sferik');
        
        $this->assertTrue($result);
    }
    
    public function testRemoveTeamMember()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->removeTeamMember(32598, 'sferik');
        
        $this->assertTrue($result);
    }
    
    public function testTeamMemberWithMember()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $is_team_member = $this->organizations()->teamMember(32598, 'pengwynn');
        
        $this->assertTrue($is_team_member);
    }
    
    public function testTeamMemberWithoutMember()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        $is_team_member = $this->organizations()->teamMember(32598, 'joeyw');
        
        $this->assertFalse($is_team_member);
    }
    
    public function testRemoveOrganizationMember()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->removeOrganizationMember('codeforamerica', 'glow-mdsol');
        
        $this->assertTrue($result);
    }
    
    public function testTeamRepositories()
    {
        $this->request()->setFixture('organization_team_repos');
        
        $repositories = $this->organizations()->teamRepositories(33239);
        
        $this->assertEquals($repositories[0]['name'], 'GitTalk');
        $this->assertEquals($repositories[0]['owner']['id'], 570695);
    }
    
    public function testAddTeamRepository()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->addTeamRepository(32598, 'reddavis/One40Proof');
        
        $this->assertTrue($result);
    }
    
    public function testRemoveTeamRepository()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->removeTeamRepository(32598, 'reddavis/One40Proof');
        
        $this->assertTrue($result);
    }
    
    public function testPublicizeMembership()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->publicizeMembership('codeforamerica', 'sferik');
        
        $this->assertTrue($result);
    }
    
    public function testUnpublicizeMembership()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->organizations()->unpublicizeMembership('codeforamerica', 'sferik');
        
        $this->assertTrue($result);
    }
}
