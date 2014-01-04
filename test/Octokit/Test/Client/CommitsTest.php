<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class CommitsTest extends \Octokit\Test\OctokitTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function commits()
    {
        return $this->client->commits();
    }
    
    public function testCommits()
    {
        $this->request()->setFixture('commits');
        
        $commits = $this->commits()->commits('sferik/rails_admin');
        
        $this->assertTrue(is_array($commits));
    }
    
    public function testCommit()
    {
        $this->request()->setFixture('commit');
        
        $commit = $this->commits()->commit('sferik/rails_admin', '3cdfabd973bc3caac209cba903cfdb3bf6636bcd');
        
        $this->assertEquals($commit['author']['login'], 'caboteria');
    }
    
    public function testCreateCommit()
    {
        $this->request()->setFixture('commit_create');
        
        $commit = $this->commits()->createCommit('octocat/Hello-World', 'My commit message', '827efc6d56897b048c772eb4087f854f46256132', '7d1b31e74ee336d15cbd21741bc88a537ed063a0');
        
        $this->assertEquals($commit['sha'], '7638417db6d59f3c431d3e1f261cc637155684cd');
        $this->assertEquals($commit['message'], 'My commit message');
        $this->assertEquals(count($commit['parents']), 1);
        $this->assertEquals($commit['parents'][0]['sha'], '7d1b31e74ee336d15cbd21741bc88a537ed063a0');
    }
    
    public function testListCommitComments()
    {
        $this->request()->setFixture('list_commit_comments');
        
        $commit_comments = $this->commits()->listCommitComments('sferik/rails_admin');
        
        $this->assertEquals($commit_comments[0]['user']['login'], 'sferik');
    }
    
    public function testCommitComments()
    {
        $this->request()->setFixture('commit_comments');
        
        $commit_comments = $this->commits()->commitComments('sferik/rails_admin', '629e9fd9d4df25528e84d31afdc8ebeb0f56fbb3');
        
        $this->assertEquals($commit_comments[0]['user']['login'], 'bbenezech');
    }
    
    public function testCommitComment()
    {
        $this->request()->setFixture('commit_comment');
        
        $commit_comment = $this->commits()->commitComments('sferik/rails_admin', '861907');
        
        $this->assertEquals($commit_comment['user']['login'], 'bbenezech');
    }
    
    public function testCreateCommitComment()
    {
        $this->request()->setFixture('commit_comment_create');
        
        $commit_comment = $this->commits()->createCommitComment('sferik/rails_admin', '629e9fd9d4df25528e84d31afdc8ebeb0f56fbb3', "Hey Eric,\r\n\r\nI think it's a terrible idea: for a number of reasons (dissections, etc.), test suite should stay deterministic IMO.\r\n", '.rspec', 1, 4);
        
        $this->assertEquals($commit_comment['body'], "Hey Eric,\r\n\r\nI think it's a terrible idea: for a number of reasons (dissections, etc.), test suite should stay deterministic IMO.\r\n");
        $this->assertEquals($commit_comment['commit_id'], '629e9fd9d4df25528e84d31afdc8ebeb0f56fbb3');
        $this->assertEquals($commit_comment['path'], '.rspec');
        $this->assertEquals($commit_comment['line'], 1);
        $this->assertEquals($commit_comment['position'], 4);
    }
    
    public function testUpdateCommitComment()
    {
        $this->request()->setFixture('commit_comment_update');
        
        $commit_comment = $this->commits()->updateCommitComment('sferik/rails_admin', '860296', "Hey Eric,\r\n\r\nI think it's a terrible idea: for a number of reasons (dissections, etc.), test suite should stay deterministic IMO.\r\n");
        
        $this->assertEquals($commit_comment['body'], "Hey Eric,\r\n\r\nI think it's a terrible idea. The test suite should stay deterministic IMO.\r\n");
    }
    
    public function testDeleteCommitComment()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $commit_comment = $this->commits()->deleteCommitComment('sferik/rails_admin', '860296');
        
        $this->assertTrue($commit_comment);
    }
    
    public function testCompare()
    {
        $this->request()->setFixture('compare');
        
        $comparison = $this->commits()->compare('gvaughn/octokit', '0e0d7ae299514da692eb1cab741562c253d44188', 'b7b37f75a80b8e84061cd45b246232ad958158f5');
        
        $this->assertEquals($comparison['base_commit']['sha'], '0e0d7ae299514da692eb1cab741562c253d44188');
        $this->assertEquals($comparison['merge_base_commit']['sha'], 'b7b37f75a80b8e84061cd45b246232ad958158f5');
    }
    
    public function testMerge()
    {
        $this->request()->setFixture('merge');
        
        $merge = $this->commits()->merge('pengwynn/api-sandbox', 'master', 'new-branch', array('commit_message' => 'Testing the merge API'));
        
        $this->assertEquals($merge['sha'], '4298c8499e0a7a160975adefdecdf9d8a5437095');
        $this->assertEquals($merge['commit']['message'], 'Testing the merge API');
    }
}
