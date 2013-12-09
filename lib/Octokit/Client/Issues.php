<?php

namespace Octokit\Client;

use Octokit\Api;

class Issues extends Api
{
    public $aliases = array(
        'issues'    => 'listIssues',
        'openIssue' => 'createIssue',
    );
    
    /**
     * Search issues within a repository.
     *
     * @param string $repo        A GitHub repository.
     * @param string $search_term The term to search for.
     * @param string $state       State, open or closed.
     * @param array  $options     Optional options.
     *
     * @return array A list of issues matching the search term and state.
     */
    public function searchIssues($repo, $search_term, $state = 'open', array $options = array())
    {
        $issues = $this->request()->get('legacy/issue/search/' . $repo . '/' . $state . '/' . $search_term, $options);
        
        return $issues['issues'];
    }
    
    /**
     * List issues for a the authenticated user or repository.
     * 
     * @see http://developer.github.com/v3/issues/#list-issues-for-this-repository
     *
     * @param string $repository A GitHub repository.
     * @param array  $options    Optional options.
     *
     * @return array A list of issues for a repository.
     */
    public function listIssues($repository = null, array $options = array())
    {
        $path = '';
        
        if (!empty($repository)) {
            $path .= 'repos/' . $repository;
        }
        
        $path .= '/issues';
        
        $issues = $this->request()->get($path, $options);
        
        return $issues['issues'];
    }
    
    /**
     * List all issues across owned and member repositories for the authenticated user.
     * 
     * @see http://developer.github.com/v3/issues/#list-issues
     *
     * @param array $options Optional options.
     *
     * @return array A list of issues for a repository.
     */
    public function userIssues(array $options = array())
    {
        return $this->request()->get('user/issues', $options);
    }
    
    /**
     * List all issues for a given organization for the authenticated user.
     *
     * @see http://developer.github.com/v3/issues/#list-issues
     *
     * @param string $org     Organization GitHub username.
     * @param array  $options Optional options.
     *
     * @return array A list of issues for a repository.
     */
    public function orgIssues($org, array $options = array())
    {
        return $this->request()->get('orgs' . $org . '/issues', $options);
    }
    
    /**
     * Create an issue for a repository.
     * 
     * @see http://developer.github.com/v3/issues/#create-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $title   A descriptive title.
     * @param string $body    A concise description.
     * @param array  $options Optional options.
     *
     * @return array Your newly created issue.
     */
    public function createIssue($repo, $title, $body, array $otions = array())
    {
        $options = array_merge(array(
            'title' => $title,
            'body'  => $body,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/issues', $options);
    }
    
    /**
     * Get a single issue from a repository.
     * 
     * @see http://developer.github.com/v3/issues/#get-a-single-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param array  $options Optional options.
     *
     * @return array The issue you requested, if it exists.
     */
    public function issue($repo, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/issues/' . $number, $options);
    }
    
    /**
     * Close an issue.
     * 
     * @see http://developer.github.com/v3/issues/#edit-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param array  $options Optional options.
     *
     * @return array The updated Issue.
     */
    public function closeIssue($repo, $number, array $options = array())
    {
        $options = array_merge(array(
            'state' => 'closed',
        ), $options);
        
        return $this->request()->patch('repos/' . $repo . '/issues/' . $number, $options);
    }
    
    /**
     * Reopen an issue.
     * 
     * @see http://developer.github.com/v3/issues/#edit-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param array  $options Optional options.
     *
     * @return array The updated Issue.
     */
    public function reopenIssue($repo, $number, array $options = array())
    {
        $options = array_merge(array(
            'state' => 'open',
        ), $options);
        
        return $this->request()->patch('repos/' . $repo . '/issues/' . $number, $options);
    }
    
    /**
     * Update an issue.
     * 
     * @see http://developer.github.com/v3/issues/#edit-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param string $title   Updated title for the issue.
     * @param string $body    Updated body of the issue.
     * @param array  $options Optional options.
     *
     * @return array The updated Issue.
     */
    public function updateIssue($repo, $number, $title, $body, array $options = array())
    {
        $options = array_merge(array(
            'title' => $title,
            'body'  => $body,
        ), $options);
        
        return $this->request()->patch('repos/' . $repo . '/issues/' . $number, $options);
    }
    
    /**
     * Get all comments attached to issues for the repository.
     * 
     * By default, Issue Comments are ordered by ascending ID.
     * 
     * @see http://developer.github.com/v3/issues/comments/#list-comments-in-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array List of issues comments.
     */
    public function issuesComments($repo, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/issues/comments', $options);
    }
    
    /**
     * Get all comments attached to an issue.
     * 
     * @see http://developer.github.com/v3/issues/comments
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param array  $options Optional options.
     *
     * @return array Array of comments that belong to an issue.
     */
    public function issueComments($repo, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/issues/' . $number . '/comments', $options);
    }
    
    /**
     * Get a single comment attached to an issue.
     *
     * @see http://developer.github.com/v3/issues/comments/#get-a-single-comment
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the comment.
     * @param array  $options Optional options.
     *
     * @return array A JSON encoded Comment.
     */
    public function issueComment($repo, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/issues/comments/' . $number, $options);
    }
    
    /**
     * Add a comment to an issue.
     * 
     * @see http://developer.github.com/v3/issues/comments/#create-a-comment
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Issue number.
     * @param string $comment Comment to be added.
     * @param array  $options Optional options.
     * 
     * @return array A JSON encoded Comment.
     */
    public function addComment($repo, $number, $comment, array $options = array())
    {
        $options = array_merge(array(
            'body' => $body,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/issues/' . $number . '/comments', $options);
    }
    
    /**
     * Update a single comment on an issue.
     * 
     * @see http://developer.github.com/v3/issues/comments/#edit-a-comment
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Comment number.
     * @param string $comment Body of the comment which will replace the existing body.
     * @param array  $options Optional options.
     * 
     * @return array A JSON encoded Comment.
     */
    public function updateComment($repo, $number, $comment, array $options = array())
    {
        $options = array_merge(array(
            'body' => $body,
        ), $options);
        
        return $this->request()->patch('repos/' . $repo . '/issues/comments/' . $number, $options);
    }
    
    /**
     * Delete a single comment.
     * 
     * @see http://developer.github.com/v3/issues/comments/#delete-a-comment
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Comment number.
     * @param array  $options Optional options.
     *
     * @return bool Success.
     */
    public function deleteComment($repo, $number, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/issues/comments/' . $number, $options);
    }
    
    /**
     * List events for an Issue.
     * 
     * @see http://developer.github.com/v3/issues/events/#list-events-for-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Issue number.
     * @param array  $options Optional options.
     *
     * @return array Array of events for that issue.
     */
    public function issueEvents($repo, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/issues/' . $number . '/events', $options);
    }
    
    /**
     * Get information on a single Issue Event.
     * 
     * @see http://developer.github.com/v3/issues/events/#get-a-single-event
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Event number.
     * @param array  $options Optional options.
     *
     * @return array A single Event for an Issue.
     */
    public function issueEvent($repo, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/issues/events/' . $number, $options);
    }
}
