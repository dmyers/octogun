<?php

namespace Octogun\Test\Client;

use Octogun\Client;

class PullsTest extends \Octogun\Test\OctogunTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'pengwynn'));
    }
    
    public function pulls()
    {
        return $this->client->pulls();
    }
    
    public function testCreatePullRequest()
    {
        $this->request()->setFixture('pull_created');
        
        $pull = $this->pulls()->createPullRequest('pengwynn/octokit', 'master', 'pengwynn:master', 'Title', 'Body');
        
        $this->assertEquals($pull['number'], 15);
        $this->assertEquals($pull['title'], 'Pull this awesome v3 stuff');
    }
    
    public function testUpdatePullRequest()
    {
        $this->request()->setFixture('pull_update');
        
        $pull = $this->pulls()->updatePullRequest('pengwynn/octokit', 67, 'New title', 'Updated body', 'closed');
        
        $this->assertEquals($pull['title'], 'New title');
        $this->assertEquals($pull['body'], 'Updated body');
        $this->assertEquals($pull['state'], 'closed');
    }
    
    public function testCreatePullRequestForIssue()
    {
        $this->request()->setFixture('pull_created');
        
        $pull = $this->pulls()->createPullRequestForIssue('pengwynn/octokit', 'master', 'pengwynn:octokit', '15');
        
        $this->assertEquals($pull['number'], 15);
    }
    
    public function testPulls()
    {
        $this->request()->setFixture('pull_requests');
        
        $pulls = $this->pulls()->pulls('pengwynn/octokit');
        
        $this->assertEquals($pulls[0]['number'], 928);
    }
    
    public function testPullRequestsComments()
    {
        $this->request()->setFixture('pull_requests_comments');
        
        $comments = $this->pulls()->pullRequestsComments('pengwynn/octokit');
        
        $this->assertEquals($comments[0]['user']['login'], 'sferik');
    }
    
    public function testPull()
    {
        $this->request()->setFixture('pull_request');
        
        $pull = $this->pulls()->pull('pengwynn/octokit', 67);
        
        $this->assertEquals($pull['number'], 67);
    }
    
    public function testPullCommmits()
    {
        $this->request()->setFixture('pull_request_commits');
        
        $commits = $this->pulls()->pullCommits('pengwynn/octokit', 67);
        
        $this->assertEquals($commits[0]['sha'], '2097821c7c5aa4dc02a2cc54d5ca51968b373f95');
    }
    
    public function testPullComments()
    {
        $this->request()->setFixture('pull_request_comments');
        
        $comments = $this->pulls()->pullComments('pengwynn/octokit', 67);
        
        $this->assertEquals($comments[0]['id'], 401530);
    }
    
    public function testPullRequestComment()
    {
        $this->request()->setFixture('pull_request_comment');
        
        $comment = $this->pulls()->pullRequestComment('pengwynn/octokit', 1903950);
        
        $this->assertEquals($comment['id'], 1903950);
        $this->assertTrue(strpos($comment['body'], 'Tests FTW.') !== false);
    }
    
    public function testCreatePullRequestComment()
    {
        $comment_content = json_decode($this->fixture('pull_request_comment_create.json'), true);
        
        $new_comment = array(
            'body'      => $comment_content['body'],
            'commit_id' => $comment_content['commit_id'],
            'path'      => $comment_content['path'],
            'position'  => $comment_content['position'],
        );
        
        $this->request()->setFixture('pull_request_comment_create');
        
        $comment = $this->pulls()->createPullRequestComment('pengwynn/octokit', 163, $new_comment['body'], $new_comment['commit_id'], $new_comment['path'], $new_comment['position']);
        
        $this->assertEquals($comment, $comment_content);
    }
    
    public function testCreatePullRequestCommentReply()
    {
        $new_comment = array(
            'body'        => 'done.',
            'in_reply_to' => 1903950,
        );
        
        $this->request()->setFixture('pull_request_comment_reply');
        
        $reply = $this->pulls()->createPullRequestCommentReply('pengwynn/octokit', 163, $new_comment['body'], $new_comment['in_reply_to']);
        
        $this->assertEquals($reply['id'], 1907270);
        $this->assertEquals($reply['body'], $new_comment['body']);
    }
    
    public function testUpdatePullRequestComment()
    {
        $this->request()->setFixture('pull_request_comment_update');
        
        $comment = $this->pulls()->updatePullRequestComment('pengwynn/octokit', 1907270, ':shipit:');
        
        $this->assertEquals($comment['body'], ':shipit:');
    }
    
    public function testDeletePullRequestComment()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->pulls()->deletePullRequestComment('pengwynn/octokit', 1907270);
        
        $this->assertTrue($result);
    }
    
    public function testMergePullRequest()
    {
        $this->request()->setFixture('pull_request_merged');
        
        $response = $this->pulls()->mergePullRequest('pengwynn/octokit', 67);
        
        $this->assertEquals($response['sha'], '2097821c7c5aa4dc02a2cc54d5ca51968b373f95');
    }
    
    public function testPullRequestFiles()
    {
        $this->request()->setFixture('pull_request_files');
        
        $files = $this->pulls()->pullRequestFiles('pengwynn/octokit', 142);
        $file = $files[0];
        
        $this->assertEquals($file['filename'], 'README.md');
        $this->assertEquals($file['additions'], 28);
    }
    
    public function testPullMerged()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $merged = $this->pulls()->pullMerged('pengwynn/octokit', 67);
        
        $this->assertTrue($merged);
    }
}
