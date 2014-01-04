<?php

namespace Octokit\Test\Client;

use Octokit\Client;

class RefsTest extends \Octokit\Test\OctokitTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function refs()
    {
        return $this->client->refs();
    }
    
    public function testRefsAll()
    {
        $this->request()->setFixture('refs');
        
        $refs = $this->refs()->refs('sferik/rails_admin');
        
        $this->assertEquals($refs[0]['ref'], 'refs/heads/actions');
    }
    
    public function testRefsTags()
    {
        $this->request()->setFixture('refs_tags');
        
        $refs = $this->refs()->refs('sferik/rails_admin', 'tags');
        
        $this->assertEquals($refs[0]['ref'], 'refs/tags/v0.0.1');
    }
    
    public function testRef()
    {
        $this->request()->setFixture('ref');
        
        $ref = $this->refs()->ref('sferik/rails_admin', 'tags/v0.0.3');
        
        $this->assertEquals($ref['object']['type'], 'tag');
        $this->assertEquals($ref['ref'], 'refs/tags/v0.0.3');
        $this->assertEquals($ref['url'], 'https://api.github.com/repos/sferik/rails_admin/git/refs/tags/v0.0.3');
    }
    
    public function testCreateRef()
    {
        $this->request()->setFixture('ref_create');
        
        $ref = $this->refs()->createRef('octocat/Hello-World', 'heads/master', '827efc6d56897b048c772eb4087f854f46256132');
        
        $this->assertEquals($ref[0]['ref'], 'refs/heads/master');
    }
    
    public function testUpdateRef()
    {
        $this->request()->setFixture('ref_update');
        
        $ref = $this->refs()->updateRef('octocat/Hello-World', 'heads/sc/featureA', 'aa218f56b14c9653891f9e74264a383fa43fefbd', true);
        
        $this->assertEquals($ref[0]['ref'], 'refs/heads/sc/featureA');
        $this->assertEquals($ref[0]['object']['sha'], 'aa218f56b14c9653891f9e74264a383fa43fefbd');
    }
    
    public function testDeleteRef()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->refs()->deleteRef('octocat/Hello-World', 'heads/feature-a');
        
        $this->assertTrue($result);
    }
}
