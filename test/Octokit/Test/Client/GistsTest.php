<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class GistsTest extends \Octokit\Test\OctokitTestCase
{
    public $client;
    protected $username;
    
    public function setUp()
    {
        $this->username = 'Oshuma';
        $this->client = new Client(array('login' => $this->username));
    }
    
    public function tearDown()
    {
        $this->configuration()->reset();
    }
    
    public function gists()
    {
        return $this->client->gists();
    }
    
    public function testPublicGists()
    {
        $this->request()->setFixture('public_gists');
        
        $public_gists = $this->gists()->publicGists();
        
        $this->assertTrue(!empty($public_gists));
    }
    
    public function testGistsWithUsername()
    {
        $this->request()->setFixture('gists');
        
        $gists = $this->gists()->gists($this->username);
        
        $this->assertEquals($gists[0]['user']['login'], $this->username);
    }
    
    public function testGistsWithoutUsername()
    {
        $this->request()->setFixture('gists');
        
        $gists = $this->gists()->gists();
        
        $this->assertEquals($gists[0]['user']['login'], $this->username);
    }
    
    public function testStarredGists()
    {
        $this->request()->setFixture('starred_gists');
        
        $gists = $this->gists()->starredGists();
        
        $this->assertTrue(!empty($gists));
    }
    
    public function testGist()
    {
        $this->request()->setFixture('gist');
        
        $gist = $this->gists()->gist(1);
        
        $this->assertEquals($gist['user']['login'], $this->username);
    }
    
    public function testCreateGist()
    {
        $gist_content = json_decode(file_get_contents(__DIR__ . '/../../../Fixtures/gist.json'), true);
        
        $new_gist = array(
            'description' => $gist_content['description'],
            'public'      => $gist_content['public'],
            'files'       => $gist_content['files'],
        );
        
        $this->request()->setFixture('gist');
        
        $gist = $this->gists()->createGist($new_gist);
        
        $this->assertEquals($gist, $gist_content);
    }
    
    public function testEditGist()
    {
        $gist_content = json_decode(file_get_contents(__DIR__ . '/../../../Fixtures/gist.json'), true);
        
        $gist_id = $gist_content['id'];
        
        $updated_gist = array_merge($gist_content, array(
            'description' => 'updated',
        ));
        
        $this->request()->setFixture(array(
            'body' => $updated_gist,
        ));
        
        $gist = $this->gists()->editGist($gist_id, array('description' => 'updated'));
        
        $this->assertEquals($gist['description'], 'updated');
    }
    
    public function testStarGist()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $success = $this->gists()->starGist(12345);
        
        $this->assertTrue($success);
    }
    
    public function testUnstarGist()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $success = $this->gists()->unstarGist(12345);
        
        $this->assertTrue($success);
    }
    
    public function testGistStarred()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $starred = $this->gists()->gistStarred(12345);
        
        $this->assertTrue($starred);
    }
    
    public function testIsNotStarred()
    {
        $this->request()->setFixture(array(
            'status' => 404,
            'body'   => '',
        ));
        
        $starred = $this->gists()->gistStarred(12345);
        
        $this->assertFalse($starred);
    }
    
    public function testForkGist()
    {
        $this->request()->setFixture('gist');
        
        $gist = $this->gists()->forkGist(12345);
        
        $this->assertEquals($gist['user']['login'], $this->username);
    }
    
    public function testDeleteGist()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $deleted = $this->gists()->deleteGist(12345);
        
        $this->assertTrue($deleted);
    }
    
    public function testGistComments()
    {
        $this->request()->setFixture('gist_comments');
        
        $comments = $this->gists()->gistComments(12345);
        
        $this->assertEquals($comments[0]['id'], 451398);
    }
    
    public function testGistComment()
    {
        $this->request()->setFixture('gist_comment');
        
        $comment = $this->gists()->gistComment('4bcad24', 12345);
        
        $this->assertEquals($comment['id'], 451398);
    }
    
    public function testCreateGistComment()
    {
        $this->request()->setFixture('gist_comment_create');
        
        $comment = $this->gists()->createGistComment('12345', 'This is very helpful.');
        
        $this->assertEquals($comment['id'], 586399);
        $this->assertEquals($comment['body'], 'This is very helpful.');
    }
    
    public function testUpdateGistComment()
    {
        $this->request()->setFixture('gist_comment_update');
        
        $comment = $this->gists()->updateGistComment('4bcad24', 12345, ':heart:');
        
        $this->assertEquals($comment['body'], ':heart:');
    }
    
    public function testDeleteGistComment()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->gists()->deleteGistComment('4bcad24', 12345);
        
        $this->assertTrue($result);
    }
}
