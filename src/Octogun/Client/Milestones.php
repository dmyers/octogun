<?php

namespace Octogun\Client;

use Octogun\Api;

class Milestones extends Api
{
    public $aliases = array(
        'milestones'    => 'listMilestones',
        'editMilestone' => 'updateMilestone',
    );
    
    /**
     * List milestones for a repository.
     * 
     * @see http://developer.github.com/v3/issues/milestones/#List-Milestones-for-an-Issue
     *
     * @param string $repository A GitHub repository.
     * @param array  $options    Optional options.
     *
     * @return array A list of milestones for a repository.
     */
    public function listMilestones($repository, array $options = array())
    {
        return $this->request()->get('repos/' . $repository . '/milestones', $options);
    }
    
    /**
     * Get a single milestone for a repository.
     * 
     * @see http://developer.github.com/v3/issues/milestones/#get-a-single-milestone
     *
     * @param string $repository A GitHub repository.
     * @param string $number     ID of the milestone.
     * @param array  $options    Optional options.
     *
     * @return array A single milestone from a repository.
     */
    public function milestone($repository, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repository . '/milestones/' . $number, $options);
    }
    
    /**
     * Create a milestone for a repository.
     * 
     * @see http://developer.github.com/v3/issues/milestones/#create-a-milestone
     *
     * @param string $repository A GitHub repository.
     * @param string $title      A unique title.
     * @param array  $options    Optional options.
     *
     * @return array A single milestone array.
     */
    public function createMilestone($repository, $title, array $options = array())
    {
        $options = array_merge(array(
            'title'  => $title,
        ), $options);
        
        return $this->request()->post('repos/' . $repository . '/milestones', $options);
    }
    
    /**
     * Update a milestone for a repository.
     * 
     * @see http://developer.github.com/v3/issues/milestones/#update-a-milestone
     *
     * @param string $repository A GitHub repository.
     * @param string $number     ID of the milestone.
     * @param array  $options    Optional options.
     *
     * @return array A single milestone array.
     */
    public function updateMilestone($repository, $number, array $options = array())
    {
        return $this->request()->patch('repos/' . $repository . '/milestones/' . $number, $options);
    }
    
    /**
     * Delete a single milestone for a repository.
     * 
     * @see http://developer.github.com/v3/issues/milestones/#delete-a-milestone
     *
     * @param string $repository A GitHub repository.
     * @param string $number     ID of the milestone.
     * @param array  $options    Optional options.
     *
     * @return bool Success.
     */
    public function deleteMilestone($repository, $number, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repository . '/milestones/' . $number, $options);
    }
}
