<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class MilestoneTest extends \Octokit\Test\OctokitTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function milestones()
    {
        return $this->client->milestones();
    }
    
    public function testListMilestones()
    {
        $this->request()->setFixture('milestones');
        
        $milestones = $this->milestones()->listMilestones('pengwynn/octokit');
        
        $this->assertEquals($milestones[0]['description'], 'Add support for API v3');
    }
    
    public function testMilestone()
    {
        $this->request()->setFixture('milestone');
        
        $milestone = $this->milestones()->milestone('pengwynn/octokit', 1);
        
        $this->assertEquals($milestone['description'], 'Add support for API v3');
    }
    
    public function testCreateMilestone()
    {
        $this->request()->setFixture(array(
            'body' => array('title' => '0.7.0'),
        ));
        
        $milestone = $this->milestones()->createMilestone('pengwynn/octokit', '0.7.0');
        
        $this->assertEquals($milestone['title'], '0.7.0');
    }
    
    public function testUpdateMilestone()
    {
        $this->request()->setFixture('milestone');
        
        $milestone = $this->milestones()->updateMilestone('pengwynn/octokit', 1, array(
            'description' => 'Add support for API v3',
        ));
        
        $this->assertEquals($milestone['description'], 'Add support for API v3');
    }
    
    public function testDeleteMilestone()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->milestones()->deleteMilestone('pengwynn/octokit', 2);
        
        $this->assertTrue($result);
    }
}
