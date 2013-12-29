<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class RepositoriesTest extends \PHPUnit_Framework_TestCase
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
    
    public function configuration()
    {
        return $this->client->configuration();
    }
    
    public function request()
    {
        return $this->client->request();
    }
    
    public function repos()
    {
        return $this->client->repositories();
    }
    
    public function testSearchUser()
    {
        $this->request()->setFixture('legacy/repositories');
        
        $repositories = $this->repos()->searchRepositories('One40Proof');
        
        $this->assertEquals($repositories[0]['name'], 'One40Proof');
    }
    
    public function testRepository()
    {
        $this->request()->setFixture('repository');
        
        $repository = $this->repos()->repository('sferik/rails_admin');
        
        $this->assertEquals($repository['name'], 'rails_admin');
    }
    
    public function testUpdateRepository()
    {
        $description = 'RailsAdmin is a Rails 3 engine that provides an easy-to-use interface for managing your data';
        
        $this->request()->setFixture(array(
            'body' => array('description' => $description),
        ));
        
        $repository = $this->repos()->editRepository('sferik/rails_admin', array(
            'description' => $description,
        ));
        
        $this->assertEquals($repository['description'], $description);
    }
    
    public function testRepositoriesWithUsername()
    {
        $this->request()->setFixture('repositories');
        
        $repositories = $this->repos()->repositories('sferik');
        
        $this->assertEquals($repositories[0]['name'], 'merb-admin');
    }
    
    public function testRepositoriesWithoutUsername()
    {
        $this->request()->setFixture('repositories');
        
        $repositories = $this->repos()->repositories();
        
        $this->assertEquals($repositories[0]['name'], 'merb-admin');
    }
    
    public function testAllRepositories()
    {
        $this->request()->setFixture('all_repositories');
        
        $repositories = $this->repos()->allRepositories();
        
        $this->assertEquals($repositories[0]['name'], 'grit');
    }
    
    public function testStarRepository()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $star = $this->repos()->star('sferik/rails_admin');
        
        $this->assertTrue($star);
    }
    
    public function testUnstarRepository()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $unstar = $this->repos()->unstar('sferik/rails_admin');
        
        $this->assertTrue($unstar);
    }
    
    public function testWatchRepository()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $watch = $this->repos()->watch('sferik/rails_admin');
        
        $this->assertTrue($watch);
    }
    
    public function testUnwatchRepository()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $unwatch = $this->repos()->unwatch('sferik/rails_admin');
        
        $this->assertTrue($unwatch);
    }
    
    public function testForkRepository()
    {
        $this->request()->setFixture('repository');
        
        $repository = $this->repos()->fork('sferik/rails_admin');
        
        $this->assertEquals($repository['name'], 'rails_admin');
    }
    
    public function testCreateRepository()
    {
        $this->request()->setFixture('repository');
        
        $repository = $this->repos()->createRepository('rails_admin');
        
        $this->assertEquals($repository['name'], 'rails_admin');
    }
    
    public function testCreateRepositoryForOrganization()
    {
        $this->request()->setFixture('organization-repository');
        
        $options = array(
            'organization' => 'comorichwebgroup',
        );
        
        $repository = $this->repos()->createRepository('rails_admin', $options);
        
        $this->assertEquals($repository['name'], 'demo');
        $this->assertEquals($repository['organization']['login'], 'CoMoRichWebGroup');
    }
    
    public function testDeleteRepository()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $delete = $this->repos()->deleteRepository('sferik/rails_admin');
        
        $this->assertTrue($delete);
    }
    
    public function testSetPrivate()
    {
        $this->request()->setFixture(array(
            'body' => array('name' => 'rails_admin', 'private' => false),
        ));
        
        $repository = $this->repos()->setPrivate('sferik/rails_admin');
        
        $this->assertEquals($repository['name'], 'rails_admin');
    }
    
    public function setPublic()
    {
        $this->request()->setFixture(array(
            'body' => array('name' => 'rails_admin', 'private' => true),
        ));
        
        $repository = $this->repos()->setPublic('sferik/rails_admin');
        
        $this->assertEquals($repository['name'], 'rails_admin');
        $this->assertFalse($repository['private']);
    }
    
    public function testDeployKeys()
    {
        $this->request()->setFixture('public_keys');
        
        $public_keys = $this->repos()->deployKeys('sferik/rails_admin');
        
        $this->assertEquals($public_keys[0]['id'], 103205);
    }
    
    public function testAddDeployKey()
    {
        $this->request()->setFixture('public_key');
        
        $public_key = $this->repos()->addDeployKey('sferik/rails_admin', 'Moss', 'ssh-dss AAAAB3NzaC1kc3MAAACBAJz7HanBa18ad1YsdFzHO5Wy1/WgXd4BV+czbKq7q23jungbfjN3eo2a0SVdxux8GG+RZ9ia90VD/X+PE4s3LV60oXZ7PDAuyPO1CTF0TaDoKf9mPaHcPa6agMJVocMsgBgwviWT1Q9VgN1SccDsYVDtxkIAwuw25YeHZlG6myx1AAAAFQCgW+OvXWUdUJPBGkRJ8ML7uf0VHQAAAIAlP5G96tTss0SKYVSCJCyocn9cyGQdNjxah4/aYuYFTbLI1rxk7sr/AkZfJNIoF2UFyO5STbbratykIQGUPdUBg1a2t72bu31x+4ZYJMngNsG/AkZ2oqLiH6dJKHD7PFx2oSPalogwsUV7iSMIZIYaPa03A9763iFsN0qJjaed+gAAAIBxz3Prxdzt/os4XGXSMNoWcS03AFC/05NOkoDMrXxQnTTpp1wrOgyRqEnKz15qC5dWk1ynzK+LJXHDZGA8lXPfCjHpJO3zrlZ/ivvLhgPdDpt13MAhIJFH06hTal0woxbk/fIdY71P3kbgXC0Ppx/0S7BC+VxqRCA4/wcM+BoDbA== host');
        
        $this->assertEquals($public_key['id'], 103205);
    }
    
    public function testRemoveDeployKey()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $delete = $this->repos()->removeDeployKey('sferik/rails_admin', 103205);
        
        $this->assertTrue($delete);
    }
    
    public function testCollaborators()
    {
        $this->request()->setFixture('collaborators');
        
        $collaborators = $this->repos()->collaborators('sferik/rails_admin');
        
        $this->assertEquals($collaborators[0]['login'], 'sferik');
    }
    
    public function testAddCollaborator()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $add = $this->repos()->addCollaborator('sferik/rails_admin', 'sferik');
        
        $this->assertTrue($add);
    }
    
    public function testRemoveCollaborator()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $delete = $this->repos()->removeCollaborator('sferik/rails_admin', 'sferik');
        
        $this->assertTrue($delete);
    }
    
    public function testRepositoryTeams()
    {
        $this->request()->setFixture('teams');
        
        $teams = $this->repos()->repositoryTeams('codeforamerica/open311');
        
        $this->assertEquals($teams[0]['name'], 'Fellows');
    }
    
    public function testContributorsWithAnonymousUsers()
    {
        $this->request()->setFixture('contributors');
        
        $contributors = $this->repos()->contributors('sferik/rails_admin', true);
        
        $this->assertEquals($contributors[0]['login'], 'sferik');
    }
    
    public function testContributorsWithoutAnonymousUsers()
    {
        $this->request()->setFixture('contributors');
        
        $contributors = $this->repos()->contributors('sferik/rails_admin');
        
        $this->assertEquals($contributors[0]['login'], 'sferik');
    }
    
    public function testStargazers()
    {
        $this->request()->setFixture('stargazers');
        
        $stargazers = $this->repos()->stargazers('sferik/rails_admin');
        
        $this->assertEquals($stargazers[0]['login'], 'sferik');
    }
    
    public function testWatchers()
    {
        $this->request()->setFixture('watchers');
        
        $watchers = $this->repos()->watchers('sferik/rails_admin');
        
        $this->assertEquals($watchers[0]['login'], 'sferik');
    }
    
    public function testNetwork()
    {
        $this->request()->setFixture('forks');
        
        $network = $this->repos()->watchers('sferik/rails_admin');
        
        $this->assertEquals($network[0]['owner']['login'], 'digx');
    }
    
    public function testLanguages()
    {
        $this->request()->setFixture('languages');
        
        $languages = $this->repos()->languages('sferik/rails_admin');
        
        $this->assertEquals($languages['Ruby'], 345701);
    }
    
    public function testTags()
    {
        $this->request()->setFixture('tags');
        
        $tags = $this->repos()->tags('pengwynn/octokit');
        
        foreach ($tags as $tag) {
            if ($tag['name'] == 'v0.6.4') {
                $tag = $tag;
            }
        }
        
        $this->assertEquals($tag['commit']['sha'], '09bcc30e7286eeb1bbde68d0ace7a6b90b1a84a2');
    }
    
    public function testBranchesMultiple()
    {
        $this->request()->setFixture('branches');
        
        $branches = $this->repos()->branches('pengwynn/octokit');
        
        foreach ($branches as $branch) {
            if ($branch['name'] == 'master') {
                $master = $branch;
            }
        }
        
        $this->assertEquals($master['commit']['sha'], '88553a397f7293b3ba176dc27cd1ab6bb93d5d14');
    }
    
    public function testBranchesSingle()
    {
        $this->request()->setFixture('branches');
        
        $branches = $this->repos()->branches('pengwynn/octokit');
        
        $this->assertEquals($branches[count($branches) - 1]['commit']['sha'], '88553a397f7293b3ba176dc27cd1ab6bb93d5d14');
    }
    
    public function testHooks()
    {
        $this->request()->setFixture('hooks');
        
        $hooks = $this->repos()->hooks('railsbp/railsbp.com');
        
        foreach ($hooks as $hk) {
            if ($hk['name'] == 'railsbp') {
                $hook = $hk;
            }
        }
        
        $this->assertEquals($hook['config']['token'], 'xAAQZtJhYHGagsed1kYR');
    }
    
    public function testHook()
    {
        $this->request()->setFixture('hook');
        
        $hook = $this->repos()->hook('railsbp/railsbp.com', 154284);
        
        $this->assertEquals($hook['config']['token'], 'xAAQZtJhYHGagsed1kYR');
    }
    
    public function testCreateHook()
    {
        $this->request()->setFixture('hook');
        
        $options = array(
            'railsbp_url' => 'http://railsbp.com',
            'token'       => 'xAAQZtJhYHGagsed1kYR',
        );
        
        $hook = $this->repos()->createHook('railsbp/railsbp.com', 'railsbp', $options);
        
        $this->assertEquals($hook['id'], 154284);
    }
    
    public function testEditHook()
    {
        $this->request()->setFixture('hook');
        
        $options = array(
            'railsbp_url' => 'http://railsbp.com',
            'token'       => 'xAAQZtJhYHGagsed1kYR',
        );
        
        $hook = $this->repos()->editHook('railsbp/railsbp.com', 154284, 'railsbp', $options);
        
        $this->assertEquals($hook['id'], 154284);
        $this->assertEquals($hook['config']['token'], 'xAAQZtJhYHGagsed1kYR');
    }
    
    public function testRemoveHook()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $delete = $this->repos()->removeHook('railsbp/railsbp.com', 154284);
        
        $this->assertTrue($delete);
    }
    
    public function testTestHook()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $delete = $this->repos()->testHook('railsbp/railsbp.com', 154284);
        
        $this->assertTrue($delete);
    }
    
    public function testEvents()
    {
        $this->request()->setFixture('repo_issues_events');
        
        $events = $this->repos()->repoIssueEvents('pengwynn/octokit');
        
        $this->assertEquals($events[0]['actor']['login'], 'ctshryock');
        $this->assertEquals($events[0]['event'], 'subscribed');
    }
    
    public function testAssignees()
    {
        $this->request()->setFixture('repo_assignees');
        
        $assignees = $this->repos()->repoAssignees('pengwynn/octokit');
        
        $this->assertEquals($assignees[0]['login'], 'adamstac');
    }
    
    public function testCheckAssignee()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $is_assignee = $this->repos()->checkAssignee('pengwynn/octokit', 'andrew');
        
        $this->assertTrue($is_assignee);
    }
    
    public function testSubscribers()
    {
        $this->request()->setFixture('subscribers');
        
        $subscribers = $this->repos()->subscribers('pengwynn/octokit');
        
        $this->assertEquals($subscribers[0]['id'], 865);
        $this->assertEquals($subscribers[0]['login'], 'pengwynn');
    }
    
    public function testSubscription()
    {
        $this->request()->setFixture('subscription');
        
        $subscription = $this->repos()->subscription('pengwynn/octokit');
        
        $this->assertTrue($subscription['subscribed']);
    }
    
    public function testUpdateSubscription()
    {
        $this->request()->setFixture('subscription_update');
        
        $options = array('subscribed' => false);
        
        $subscription = $this->repos()->updateSubscription('pengwynn/octokit', $options);
        
        $this->assertFalse($subscription['subscribed']);
    }
    
    public function testDeleteSubscriptionSuccess()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $delete = $this->repos()->deleteSubscription('pengwynn/octokit');
        
        $this->assertTrue($delete);
    }
    
    public function testDeleteSubscriptionFail()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        $delete = $this->repos()->deleteSubscription('pengwynn/octokit');
        
        $this->assertFalse($delete);
    }
}
