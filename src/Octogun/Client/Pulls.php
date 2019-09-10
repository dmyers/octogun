<?php

namespace Octogun\Client;

use Octogun\Api;

class Pulls extends Api
{
    public $aliases = [
        'pulls'               => 'pullRequests',
        'pull'                => 'pullRequest',
        'pullCommits'         => 'pullRequestCommits',
        'pullsComments'       => 'pullRequestsComments',
        'reviewsComments'     => 'pullRequestsComments',
        'pullComments'        => 'pullRequestComments',
        'reviewComments'      => 'pullRequestComments',
        'pullComment'         => 'pullRequestComment',
        'reviewComment'       => 'pullRequestComment',
        'createPullComment'   => 'createPullRequestComment',
        'createViewComment'   => 'createPullRequestComment',
        'createPullReply'     => 'createPullRequestCommentReply',
        'createReviewReply'   => 'createPullRequestCommentReply',
        'updatePullComment'   => 'updatePullRequestComment',
        'updateReviewComment' => 'updatePullRequestComment',
        'deletePullComment'   => 'deletePullRequestComment',
        'deleteReviewComment' => 'deletePullRequestComment',
        'pullRequestFiles'    => 'pullRequestFiles',
        'pullRequestMerged'   => 'pullMerged',
    ];
    
    /**
     * List pull requests for a repository.
     * 
     * @see http://developer.github.com/v3/pulls/#list-pull-requests
     *
     * @param string $repo    A GitHub repository.
     * @param string $state   Method options.
     * @param array  $options Optional options.
     *
     * @return array Array of pulls.
     */
    public function pullRequests($repo, $state = 'open', array $options = [])
    {
        $options = array_merge([
            'state' => $state,
        ]);
        
        return $this->request()->get('repos/' . $repo . '/pulls', $options);
    }
    
    /**
     * Get a pull request.
     * 
     * @see http://developer.github.com/v3/pulls/#get-a-single-pull-request
     *
     * @param string $repo    A GitHub repository.
     * @param int    $number  Number of the pull request to fetch.
     * @param array  $options Optional options.
     *
     * @return array Pull request info.
     */
    public function pullRequest($repo, $number, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/pulls/' . $number, $options);
    }
    
    /**
     * Create a pull request.
     * 
     * @see http://developer.github.com/v3/pulls/#create-a-pull-request
     *
     * @param string $repo    A GitHub repository.
     * @param string $base    The branch (or git ref) you want your changes
     *                        pulled into. This should be an existing branch on the current
     *                        repository. You cannot submit a pull request to one repo that requests
     *                        a merge to a base of another repo.
     * @param string $head    The branch (or git ref) where your changes are implemented.
     * @param string $title   Title for the pull request.
     * @param string $body    The body for the pull request. Supports GFM.
     * @param array  $options Optional options.
     *
     * @return array The newly created pull request.
     */
    public function createPullRequest($repo, $base, $head, $title, $body, array $options = [])
    {
        $options = array_merge([
            'base'  => $base,
            'head'  => $head,
            'title' => $title,
            'body'  => $body,
        ]);
        
        return $this->request()->post('repos/' . $repo . '/pulls', $options);
    }
    
    /**
     * Create a pull request from existing issue.
     * 
     * @see http://developer.github.com/v3/pulls/#alternative-input
     *
     * @param string $repo    A GitHub repository.
     * @param string $base    The branch (or git ref) you want your changes
     *                        pulled into. This should be an existing branch on the current
     *                        repository. You cannot submit a pull request to one repo that requests
     *                        a merge to a base of another repo.
     * @param string $head    The branch (or git ref) where your changes are implemented.
     * @param int    $issue   Number of Issue on which to base this pull request.
     * @param array  $options Optional options.
     *
     * @return array The newly created pull request.
     */
    public function createPullRequestForIssue($repo, $base, $head, $issue, array $options = [])
    {
        $options = array_merge([
            'base'  => $base,
            'head'  => $head,
            'issue' => $issue,
        ]);
        
        return $this->request()->post('repos/' . $repo . '/pulls', $options);
    }
    
    /**
     * Update a pull request.
     * 
     * @see http://developer.github.com/v3/pulls/#update-a-pull-request
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      Id of pull request to update.
     * @param string $title   Title for the pull request.
     * @param string $body    Body content for pull request. Supports GFM.
     * @param string $state   State of the pull request. `open` or `closed`.
     * @param array  $options Optional options.
     *
     * @return array Array representing updated pull request.
     */
    public function updatePullRequest($repo, $id, $title = null, $body = null, $state = null, array $options = [])
    {
        $options = array_merge([
            'title' => $title,
            'body'  => $body,
            'state' => $state,
        ]);
        
        foreach ($options as $key => $value) {
            if ($value == null) {
                unset($options[$key]);
            }
        }
        
        return $this->request()->patch('repos/' . $repo . '/pulls/' . $id, $options);
    }
    
    /**
     * List commits on a pull request.
     * 
     * @see http://developer.github.com/v3/pulls/#list-commits-on-a-pull-request
     *
     * @param string $repo    A GitHub repository.
     * @param int    $number  Number of pull request.
     * @param array  $options Optional options.
     *
     * @return array List of commits.
     */
    public function pullRequestCommits($repo, $number, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/pulls/' . $number . '/commits', $options);
    }
    
    /**
     * List pull request comments for a repository.
     * 
     * By default, Review Comments are ordered by ascending ID.
     * 
     * @see http://developer.github.com/v3/pulls/comments/#list-comments-in-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array  List of pull request review comments.
     */
    public function pullRequestsComments($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/pulls/comments', $options);
    }
    
    /**
     * List comments on a pull request.
     * 
     * @see http://developer.github.com/v3/pulls/#list-comments-on-a-pull-request
     *
     * @param string $repo    A GitHub repository.
     * @param int    $number  Number of pull request.
     * @param array  $options Optional options.
     *
     * @return array List of comments.
     */
    public function pullRequestComments($repo, $number, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/pulls/' . $number . '/comments', $options);
    }
    
    /**
     * Get a pull request comment.
     * 
     * @see http://developer.github.com/v3/pulls/comments/#get-a-single-comment
     *
     * @param string $repo       A GitHub repository.
     * @param int    $comment_id Id of comment to get.
     * @param array  $options    Optional options.
     *
     * @return array Array representing the comment.
     */
    public function pullRequestComment($repo, $comment_id, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/pulls/comments/' . $comment_id, $options);
    }
    
    /**
     * Create a pull request comment.
     * 
     * @see http://developer.github.com/v3/pulls/comments/#create-a-comment
     *
     * @param string $repo      A GitHub repository.
     * @param int    $pull_id   Pull request id.
     * @param string $body      Comment content.
     * @param string $commit_id Sha of the commit to comment on.
     * @param string $path      Relative path of the file to comment on.
     * @param int    $position  Line index in the diff to comment on.
     * @param array  $options   Optional options.
     *
     * @return array Array representing the new comment.
     */
    public function createPullRequestComment($repo, $pull_id, $body, $commit_id, $path, $position, array $options = [])
    {
        $options = array_merge([
            'body'      => $body,
            'commit_id' => $commit_id,
            'path'      => $path,
            'position'  => $position,
        ]);
        
        return $this->request()->post('repos/' . $repo . '/pulls/' . $pull_id . '/comments', $options);
    }
    
    /**
     * Create reply to a pull request comment.
     * 
     * @see http://developer.github.com/v3/pulls/comments/#create-a-comment
     *
     * @param string $repo       A GitHub repository.
     * @param int    $pull_id    Pull request id.
     * @param string $body       Comment contents.
     * @param int    $comment_id Comment id to reply to.
     * @param array  $options    Optional options.
     *
     * @return array Array representing new comment.
     */
    public function createPullRequestCommentReply($repo, $pull_id, $body, $comment_id, array $options = [])
    {
        $options = array_merge([
            'body'        => $body,
            'in_reply_to' => $comment_id,
        ]);
        
        return $this->request()->post('repos/' . $repo . '/pulls/' . $pull_id . '/comments', $options);
    }
    
    /**
     * Update pull request comment.
     * 
     * @see http://developer.github.com/v3/pulls/comments/#edit-a-comment
     *
     * @param string $repo       A GitHub repository.
     * @param int    $comment_id Id of the comment to update
     * @param string $body       Updated comment content.
     * @param array  $options    Optional options.
     *
     * @return array Array representing the updated comment.
     */
    public function updatePullRequestComment($repo, $comment_id, $body, array $options = [])
    {
        $options = array_merge([
            'body' => $body,
        ]);
        
        return $this->request()->patch('repos/' . $repo . '/pulls/comments/' . $comment_id, $options);
    }
    
    /**
     * Delete pull request comment.
     * 
     * @see http://developer.github.com/v3/pulls/comments/#delete-a-comment
     *
     * @param string $repo       A GitHub repository.
     * @param int    $comment_id Id of the comment to delete.
     * @param array  $options    Optional options.
     *
     * @return bool True if deleted, false otherwise.
     */
    public function deletePullRequestComment($repo, $comment_id, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/pulls/comments/' . $comment_id, $options);
    }
    
    /**
     * List files on a pull request.
     * 
     * @see http://developer.github.com/v3/pulls/#list-files-on-a-pull-request
     *
     * @param string $repo    A GitHub repository.
     * @param int    $number  Number of pull request.
     * @param array  $options Optional options.
     *
     * @return array List of files.
     */
    public function pullRequestFiles($repo, $number, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/pulls/' . $number . '/files', $options);
    }
    
    /**
     * Merge a pull request.
     * 
     * @see http://developer.github.com/v3/pulls/#merge-a-pull-request-merge-buttontrade
     *
     * @param string $repo           A GitHub repository.
     * @param int    $number         Number of pull request.
     * @param string $commit_message Optional commit message for the merge commit.
     * @param array  $options        Optional options.
     *
     * @return array Merge commit info if successful.
     */
    public function mergePullRequest($repo, $number, $commit_message = '', array $options = [])
    {
        $options = array_merge([
            'commit_message' => $commit_message,
        ]);
        
        return $this->request()->put('repos/' . $repo . '/pulls/' . $number . '/merge', $options);
    }
    
    /**
     * Check pull request merge status.
     * 
     * @see http://developer.github.com/v3/pulls/#get-if-a-pull-request-has-been-merged
     *
     * @param string $repo    A GitHub repository.
     * @param int    $number  Number of pull request.
     * @param array  $options Optional options.
     *
     * @return bool True if the pull request has been merged.
     */
    public function pullMerged($repo, $number, array $options = [])
    {
        return $this->request()->booleanFromResponse('get', 'repos/' . $repo . '/pulls/' . $number . '/merge', $options);
    }
}
