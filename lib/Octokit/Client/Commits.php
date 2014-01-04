<?php

namespace Octokit\Client;

use Octokit\Api;

class Commits extends Api
{
    public $aliases = array(
        'listCommits' => 'commits',
    );
    
    /**
     * List commits.
     * 
     * @see http://developer.github.com/v3/repos/commits/#list-commits-on-a-repository
     *
     * @param string $repo          A GitHub repository.
     * @param string $sha_or_branch Commit SHA or branch name from which to start the list.
     * @param array  $options       Optional options.
     *
     * @return array An array of representing commits.
     */
    public function commits($repo, $sha_or_branch = 'master', array $options = array())
    {
        $options = array_merge(array(
            'sha'      => $sha_or_branch,
            'per_page' => 25,
        ), $options);
        
        return $this->request()->get('repos/' . $repo . '/commits', $options);
    }
    
    /**
     * Get a single commit.
     * 
     * @see http://developer.github.com/v3/repos/commits/#get-a-single-commit
     *
     * @param string $repo    A GitHub repository.
     * @param string $sha     The SHA of the commit to fetch.
     * @param array  $options Optional options.
     *
     * @return array An array representing the commit.
     */
    public function commit($repo, $sha, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/commits/' . $sha, $options);
    }
    
    /**
     * Create a commit.
     * 
     * @see http://developer.github.com/v3/git/commits/#create-a-commit
     *
     * @param string $repo    A GitHub repository.
     * @param string $message The commit message
     * @param string $tree    The SHA of the tree object the new commit will point to.
     * @param string $parents One SHA (for a normal commit) or an array of SHAs (for a merge) of the new commit's parent commits. If ommitted or empty, a root commit will be created
     * @param array  $options Optional options.
     *
     * @return array An array representing the new commit.
     */
    public function createCommit($repo, $message, $tree, $parents = null, array $options = array())
    {
        $options = array_merge(array(
            'message' => $message,
            'tree'    => $tree,
        ), $options);
        
        if (!empty($parents)) {
            $options['parents'] = $parents;
        }
        
        return $this->request()->post('repos/' . $repo . '/git/commits', $options);
    }
    
    /**
     * List all commit comments.
     * 
     * @see http://developer.github.com/v3/repos/comments/#list-commit-comments-for-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array An array of representing comments.
     */
    public function listCommitComments($repo, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/comments', $options);
    }
    
    /**
     * List comments for a single commit.
     * 
     * @see http://developer.github.com/v3/repos/comments/#list-comments-for-a-single-commit
     *
     * @param string $repo    A GitHub repository.
     * @param string $sha     The ID of the comment to fetch.
     * @param array  $options Optional options.
     *
     * @return array  An array of representing comments.
     */
    public function commitComments($repo, $sha, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/commits/' . $sha . '/comments', $options);
    }
    
    /**
     * Get a single commit comment.
     * 
     * @see http://developer.github.com/v3/repos/comments/#get-a-single-commit-comment
     *
     * @param string $repo    A GitHub repository.
     * @param string $id      The ID of the comment to fetch.
     * @param array  $options Optional options.
     *
     * @return array An array representing the comment.
     */
    public function commitComment($repo, $id, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/comments/' . $id, $options);
    }
    
    /**
     * Create a commit comment.
     * 
     * @see http://developer.github.com/v3/repos/comments/#create-a-commit-comment
     *
     * @param string $repo     A GitHub repository.
     * @param string $sha      Sha of the commit to comment on.
     * @param string $body     Message.
     * @param string $path     Relative path of file to comment on.
     * @param int    $line     Line number in the file to comment on.
     * @param int    $position Line index in the diff to comment on.
     * @param array  $options  Optional options.
     *
     * @return array An array representing the new commit comment.
     */
    public function createCommitComment($repo, $sha, $body, $path = null, $line = null, $position = null, array $options = array())
    {
        $options = array_merge(array(
            'body'      => $body,
            'commit_id' => $sha,
            'path'      => $path,
            'line'      => $line,
            'position'  => $position,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/commits/' . $sha . '/comments', $options);
    }
    
    /**
     * Update a commit comment.
     * 
     * @see http://developer.github.com/v3/repos/comments/#update-a-commit-comment
     *
     * @param string $repo    A GitHub repository.
     * @param string $id      The ID of the comment to update.
     * @param string $body    Message.
     * @param array  $options Optional options.
     *
     * @return array An array representing the updated commit comment.
     */
    public function updateCommitComment($repo, $id, $body, array $options = array())
    {
        $options = array_merge(array(
            'body' => $body,
        ), $options);
        
        return $this->request()->patch('repos/' . $repo . '/comments/' . $id, $options);
    }
    
    /**
     * Delete a commit comment.
     * 
     * @see http://developer.github.com/v3/repos/comments/#delete-a-commit-comment
     *
     * @param string $repo    A GitHub repository.
     * @param string $id      The ID of the comment to delete.
     * @param array  $options Optional options.
     *
     * @return bool
     */
    public function deleteCommitComment($repo, $id, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'repo/' . $repo . '/comments/' . $id, $options);
    }
    
    /**
     * Compare two commits.
     * 
     * @see http://developer.github.com/v3/repos/commits/#compare-two-commits
     *
     * @param string $repo    A GitHub repository.
     * @param string $start   The sha of the starting commit.
     * @param string $endd    The sha of the ending commit.
     * @param array  $options Optional options.
     *
     * @return array An array representing the comparison.
     */
    public function compare($repo, $start, $endd, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/compare/' . $start . '...' . $endd, $options);
    }
    
    /**
     * Merge a branch or sha.
     * 
     * @see http://developer.github.com/v3/repos/merging/#perform-a-merge
     *
     * @param string $repo    A GitHub repository.
     * @param string $base    The name of the base branch to merge into.
     * @param string $head    The branch or SHA1 to merge.
     * @param array  $options Optional options.
     *
     * @return array An array representing the comparison.
     */
    public function merge($repo, $base, $head, array $options = array())
    {
        $options = array_merge(array(
            'base' => $base,
            'head' => $head,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/merges', $options);
    }
}
