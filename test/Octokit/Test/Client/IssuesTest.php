<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class IssuesTest extends \Octokit\Test\OctokitTestCase
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
    
    public function issues()
    {
        return $this->client->issues();
    }
    
    public function testSearchIssues()
    {
        $this->request()->setFixture('legacy/issues');
        
        $issues = $this->issues()->searchIssues('sferik/rails_admin', 'activerecord');
        
        $this->assertEquals($issues[0]['number'], 105);
    }
    
    public function testListIssuesForRepo()
    {
        $this->request()->setFixture('issues');
        
        $issues = $this->issues()->issues('sferik/rails_admin');
        
        $this->assertEquals($issues[0]['number'], 388);
    }
    
    public function testListIssuesForAuthenticatedUser()
    {
        $this->request()->setFixture('issues');
        
        $issues = $this->issues()->issues();
        
        $this->assertEquals($issues[0]['number'], 388);
    }
    
    public function testUserIssues()
    {
        $this->request()->setFixture('user_issues');
        
        $issues = $this->issues()->userIssues();
        
        $this->assertEquals($issues[0]['number'], 43);
    }
    
    public function testOrgIssues()
    {
        $this->request()->setFixture('org_issues');
        
        $issues = $this->issues()->orgIssues('github');
        
        $this->assertEquals($issues[0]['number'], 43);
    }
    
    public function testCreateIssue()
    {
        $this->request()->setFixture('issue');
        
        $issue = $this->issues()->createIssue('ctshryock/octokit', 'Migrate issues to v3', 'Move all Issues calls to v3 of the API');
        
        $this->assertEquals($issue['number'], 12);
    }
    
    public function testIssue()
    {
        $this->request()->setFixture('issue');
        
        $issue = $this->issues()->issue('ctshryock/octokit', 12);
        
        $this->assertEquals($issue['number'], 12);
    }
    
    public function testIssueFull()
    {
        $this->request()->setFixture('issue_full');
        
        $issue = $this->issues()->issue('pengwynn/octokit', 1);
        
        $this->assertTrue(strpos($issue['body_html'], '<p>Create, Edit, Delete missing') !== false);
        $this->assertTrue(strpos($issue['body_text'], 'Create, Edit, Delete missing') !== false);
    }
    
    public function testCloseIssue()
    {
        $this->request()->setFixture('issue_closed');
        
        $issue = $this->issues()->closeIssue('ctshryock/octokit', 12);
        
        $this->assertEquals($issue['number'], 12);
        $this->assertTrue(array_key_exists('closed_at', $issue));
        $this->assertEquals($issue['state'], 'closed');
    }
    
    public function testReopenIssue()
    {
        $this->request()->setFixture('issue');
        
        $issue = $this->issues()->reopenIssue('ctshryock/octokit', 12);
        
        $this->assertEquals($issue['number'], 12);
        $this->assertEquals($issue['state'], 'open');
    }
    
    public function testUpdateIssue()
    {
        $this->request()->setFixture('issue');
        
        $issue = $this->issues()->updateIssue('ctshryock/octokit', 12, 'Use all the v3 api!', '');
        
        $this->assertEquals($issue['number'], 12);
    }
    
    public function testRepositoryIssuesComments()
    {
        $this->request()->setFixture('repository_issues_comments');
        
        $comments = $this->issues()->issuesComments('pengwynn/octokit');
        
        $this->assertEquals($comments[0]['user']['login'], 'pengwynn');
    }
    
    public function testIssueComments()
    {
        $this->request()->setFixture('comments');
        
        $comments = $this->issues()->issueComments('pengwynn/octokit', 25);
        
        $this->assertEquals($comments[0]['user']['login'], 'ctshryock');
    }
    
    public function testIssueComment()
    {
        $this->request()->setFixture('comment');
        
        $comment = $this->issues()->issueComment('pengwynn/octokit', 25);
        
        $this->assertEquals($comment['user']['login'], 'ctshryock');
        $this->assertEquals($comment['url'], 'https://api.github.com/repos/pengwynn/octokit/issues/comments/1194690');
    }
    
    public function testAddComment()
    {
        $this->request()->setFixture('comment');
        
        $comment = $this->issues()->addComment('pengwynn/octokit', 25, 'A test comment');
        
        $this->assertEquals($comment['user']['login'], 'ctshryock');
    }
    
    public function testUpdateComment()
    {
        $this->request()->setFixture('comment');
        
        $comment = $this->issues()->updateComment('pengwynn/octokit', 1194549, 'A test comment update');
        
        $this->assertEquals($comment['user']['login'], 'ctshryock');
    }
    
    public function testDeleteComment()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->issues()->deleteComment('pengwynn/octokit', 1194549);
        
        $this->assertTrue($result);
    }
    
    public function testIssueEvents()
    {
        $this->request()->setFixture('issue_events');
        
        $events = $this->issues()->issueEvents('pengwynn/octokit', 38);
        
        $this->assertEquals($events[0]['event'], 'mentioned');
        $this->assertEquals($events[count($events) - 1]['actor']['login'], 'ctshryock');
    }
    
    public function testIssueEvent()
    {
        $this->request()->setFixture('issue_event');
        
        $event = $this->issues()->issueEvent('pengwynn/octokit', 3094334);
        
        $this->assertEquals($event['actor']['login'], 'sferik');
        $this->assertEquals($event['event'], 'closed');
    }
}
