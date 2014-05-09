<?php

namespace Octogun\Test\Client;

use Octogun\Client;

class LabelsTest extends \Octogun\Test\OctogunTestCase
{
    public function setUp()
    {
        $this->client = new Client(array('login' => 'sferik'));
    }
    
    public function labels()
    {
        return $this->client->labels();
    }
    
    public function testLabels()
    {
        $this->request()->setFixture('labels');
        
        $labels = $this->labels()->labels('pengwynn/octokit');
        
        $this->assertEquals($labels[0]['name'], 'V3 Transition');
    }
    
    public function testLabel()
    {
        $this->request()->setFixture('label');
        
        $label = $this->labels()->label('pengwynn/octokit', 'V3 Addition');
        
        $this->assertEquals($label['name'], 'V3 Addition');
    }
    
    public function testAddLabelWithColor()
    {
        $this->request()->setFixture('label');
        
        $label = $this->labels()->addLabel('pengwynn/octokit', 'a significant bug', 'ededed');
        
        $this->assertEquals($label['color'], 'ededed');
        $this->assertEquals($label['name'], 'V3 Addition');
    }
    
    public function testAddLabelWithDefaultColor()
    {
        $this->request()->setFixture('label');
        
        $label = $this->labels()->addLabel('pengwynn/octokit', 'a significant bug');
        
        $this->assertEquals($label['color'], 'ededed');
        $this->assertEquals($label['name'], 'V3 Addition');
    }
    
    public function testUpdateLabel()
    {
        $this->request()->setFixture('label');
        
        $label = $this->labels()->updateLabel('pengwynn/octokit', 'V3 Addition', array(
            'color' => 'ededed',
        ));
        
        $this->assertEquals($label['color'], 'ededed');
    }
    
    public function testDeleteLabel()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->labels()->deleteLabel('pengwynn/octokit', 'V3 Transition');
        
        $this->assertTrue($result);
    }
    
    public function testRemoveLabel()
    {
        $this->request()->setFixture('labels');
        
        $response = $this->labels()->removeLabel('pengwynn/octokit', 23, 'V3 Transition');
        
        $this->assertEquals($response[count($response) - 1]['name'], 'Bug');
    }
    
    public function testRemoveAllLabels()
    {
        $this->request()->setFixture(array(
            'status' => 204,
            'body'   => '',
        ));
        
        $result = $this->labels()->removeAllLabels('pengwynn/octokit', 23);
        
        $this->assertTrue($result);
    }
    
    public function testAddLabelsToAnIssue()
    {
        $this->request()->setFixture('labels');
        
        $labels = $this->labels()->addLabelsToAnIssue('pengwynn/octokit', 42, array(
            'V3 Transition', 'Bug',
        ));
        
        $this->assertEquals($labels[0]['name'], 'V3 Transition');
        $this->assertEquals($labels[count($labels) - 1]['name'], 'Bug');
    }
    
    public function testReplaceAllLabels()
    {
        $this->request()->setFixture('labels');
        
        $labels = $this->labels()->replaceAllLabels('pengwynn/octokit', 42, array(
            'V3 Transition', 'V3 Adding',
        ));
        
        $this->assertEquals($labels[0]['name'], 'V3 Transition');
    }
    
    public function testLabelsForMilestone()
    {
        $this->request()->setFixture('labels');
        
        $labels = $this->labels()->labelsForMilestone('pengwynn/octokit', 2);
        
        $this->assertEquals(count($labels), 3);
    }
    
    public function testLabelsForIssue()
    {
        $this->request()->setFixture('labels');
        
        $labels = $this->labels()->labelsForIssue('pengwynn/octokit', 37);
        
        $this->assertEquals($labels[0]['name'], 'V3 Transition');
        $this->assertEquals($labels[count($labels) - 1]['name'], 'Bug');
    }
}
