<?php

namespace Octogun\Test\Client;

use Octogun\Client;

class StatsTest extends \Octogun\Test\OctogunTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function stats()
    {
        return $this->client->stats();
    }
    
    public function testContributorStats()
    {
        $this->request()->setFixture('contributor_stats');
        
        $stats = $this->stats()->contributorsStats('pengwynn/octokit');
        
        $this->assertEquals($stats[0]['author']['login'], 'pengwynn');
    }
    
    public function testCommitActivityStats()
    {
        $this->request()->setFixture('commit_activity_stats');
        
        $stats = $this->stats()->commitActivityStats('pengwynn/octokit');
        
        $this->assertEquals($stats[0]['week'], 1336867200);
    }
    
    public function testCodeFrequencyStats()
    {
        $this->request()->setFixture('code_frequency_stats');
        
        $stats = $this->stats()->codeFrequencyStats('pengwynn/octokit');
        
        $this->assertEquals($stats[0][0], 1260057600);
    }
    
    public function testParticipationStats()
    {
        $this->request()->setFixture('participation_stats');
        
        $stats = $this->stats()->participationStats('pengwynn/octokit');
        
        $this->assertEquals($stats['owner'][0], 5);
    }
    
    public function testPunchCardStats()
    {
        $this->request()->setFixture('punch_card_stats');
        
        $stats = $this->stats()->participationStats('pengwynn/octokit');
        
        $this->assertEquals($stats[count($stats) - 1][0], 6);
    }
}
