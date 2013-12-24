<?php

namespace Octokit\Client;

use Octokit\Api;

class Gists extends Api
{
    public $aliases = array(
        'listGists' => 'gists',
    );
    
    /**
     * List gists for a user or all public gists.
     * 
     * @see http://developer.github.com/v3/gists/#list-gists
     *
     * @param string $username An optional user to filter listing.
     * @param array  $options  Optional options.
     *
     * @return array A list of gists.
     */
    public function gists($username = null, array $options = array())
    {
        if (empty($username)) {
            return $this->request()->get('gists', $options);
        }
        else {
            return $this->request()->get('users/' . $username . '/gists', $options);
        }
    }
    
    /**
     * List public gists.
     * 
     * @see http://developer.github.com/v3/gists/#list-gists
     *
     * @param array $options Optional options.
     *
     * @return array A list of gists.
     */
    public function publicGists(array $options = array())
    {
        return $this->request()->get('gists/public', $options);
    }
    
    /**
     * List the authenticated user’s starred gists.
     * 
     * @see http://developer.github.com/v3/gists/#list-gists
     *
     * @param array $options Optional options.
     *
     * @return array A list of gists.
     */
    public function starredGists(array $options = array())
    {
        return $this->request()->get('gists/starred', $options);
    }
    
    /**
     * Get a single gist.
     * 
     * @see http://developer.github.com/v3/gists/#get-a-single-gist
     *
     * @param string $gist    ID of gist to fetch.
     * @param array  $options Optional options.
     *
     * @return array Gist information.
     */
    public function gist($gist, array $options = array())
    {
        return $this->request()->get('gists/' . $gist, $options);
    }
    
    /**
     * Create a gist.
     * 
     * @see http://developer.github.com/v3/gists/#create-a-gist
     *
     * @param array $options Optional options.
     *
     * @return array Newly created gist info.
     */
    public function createGist(array $options = array())
    {
        return $this->request()->post('gists', $options);
    }
    
    /**
     * Edit a gist.
     * 
     * @see http://developer.github.com/v3/gists/#edit-a-gist
     *
     * @param string $gist    Gist ID.
     * @param array  $options Optional options.
     *
     * @return array Updated gist info.
     */
    public function editGist($gist, array $options = array())
    {
        return $this->request()->patch('gists/' . $gist, $options);
    }
    
    /**
     * Star a gist.
     * 
     * @see http://developer.github.com/v3/gists/#star-a-gist
     *
     * @param string $gist    Gist ID.
     * @param array  $options Optional options.
     *
     * @return bool Indicates if gist is starred successfully.
     */
    public function starGist($gist, array $options = array())
    {
        return $this->request()->booleanFromResponse('put', 'gists/' . $gist . '/star', $options);
    }
    
    /**
     * Unstar a gist.
     * 
     * @see http://developer.github.com/v3/gists/#unstar-a-gist
     *
     * @param string $gist    Gist ID.
     * @param array  $options Optional options.
     *
     * @return bool Indicates if gist is unstarred successfully.
     */
    public function unstarGist($gist, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'gists/' . $gist . '/star', $options);
    }
    
    /**
     * Check if a gist is starred.
     * 
     * @see http://developer.github.com/v3/gists/#check-if-a-gist-is-starred
     *
     * @param string $gist    Gist ID.
     * @param array  $options Optional options.
     *
     * @return bool Indicates if gist is starred.
     */
    public function gistStarred($gist, array $options = array())
    {
        return $this->request()->booleanFromResponse('get', 'gists/' . $gist . '/star', $options);
    }
    
    /**
     * Fork a gist.
     * 
     * @see http://developer.github.com/v3/gists/#fork-a-gist
     *
     * @param string $gist    Gist ID.
     * @param array  $options Optional options.
     *
     * @return array Data for the new gist.
     */
    public function forkGist($gist, array $options = array())
    {
        return $this->request()->post('gists/' . $gist . '/forks', $options);
    }
    
    /**
     * Delete a gist.
     * 
     * @see http://developer.github.com/v3/gists/#delete-a-gist
     *
     * @param string $gist    Gist ID.
     * @param array  $options Optional options.
     *
     * @return bool Indicating success of deletion.
     */
    public function deleteGist($gist, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'gists/' . $gist, $options);
    }
    
    /**
     * List gist comments.
     * 
     * @see http://developer.github.com/v3/gists/comments/#list-comments-on-a-gist
     *
     * @param string $gist_id Gist Id.
     * @param array  $options Optional options.
     *
     * @return array Array of representing comments.
     */
    public function gistComments($gist_id, array $options = array())
    {
        return $this->request()->get('gists/' . $gist_id . '/comments', $options);
    }
    
    /**
     * Get gist comment.
     * 
     * @see http://developer.github.com/v3/gists/comments/#get-a-single-comment
     *
     * @param string $gist_id         Id of the gist.
     * @param int    $gist_comment_id Id of the gist comment.
     * @param array  $options         Optional options.
     *
     * @return array Array representing gist comment.
     */
    public function gistComment($gist_id, $gist_comment_id, array $options = array())
    {
        return $this->request()->get('gists/' . $gist_id . '/comments/' . $gist_comment_id, $options);
    }
    
    /**
     * Create gist comment.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/gists/comments/#create-a-comment
     *
     * @param string $gist_id Id of the gist.
     * @param string $comment Comment contents.
     * @param array  $options Optional options.
     *
     * @return array Array representing the new comment.
     */
    public function createGistComment($gist_id, $comment, array $options = array())
    {
        $options = array_merge(array(
            'body' => $comment,
        ), $options);
        
        return $this->request()->post('gists/' . $gist_id . '/comments', $options);
    }
    
    /**
     * Update gist comment.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/gists/comments/#edit-a-comment
     *
     * @param string $gist_id         Id of the gist.
     * @param int    $gist_comment_id Id of the gist comment to update.
     * @param string $comment         Updated comment contents.
     * @param array  $options         Optional options.
     *
     * @return array Array representing the updated comment.
     */
    public function updateGistComment($gist_id, $gist_comment_id, $comment, array $options = array())
    {
        $options = array_merge(array(
            'body' => $comment,
        ), $options);
        
        return $this->request()->patch('gists/' . $gist_id . '/comments/' . $gist_comment_id, $options);
    }
    
    /**
     * Delete gist comment.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/gists/comments/#delete-a-comment
     *
     * @param string $gist_id         Id of the gist.
     * @param int    $gist_comment_id Id of the gist comment to delete.
     * @param array  $options         Optional options.
     *
     * @return bool True if comment deleted, false otherwise.
     */
    public function deleteGistComment($gist_id, $gist_comment_id, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'gists/' . $gist_id . '/comments/' . $gist_comment_id, $options);
    }
}
