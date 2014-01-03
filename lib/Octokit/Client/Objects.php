<?php

namespace Octokit\Client;

use Octokit\Api;

class Objects extends Api
{
    /**
     * Get a single tree, fetching information about its root-level objects.
     * 
     * @see http://developer.github.com/v3/git/trees/#get-a-tree
     *
     * @param string $repo     A GitHub repository.
     * @param string $tree_sha The SHA of the tree to fetch.
     * @param array  $options  Optional options.
     *
     * @return array An array representing the fetched tree.
     */
    public function tree($repo, $tree_sha, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/git/trees/' . $tree_sha, $options);
    }
    
    /**
     * Create a tree.
     * 
     * @see http://developer.github.com/v3/git/trees/#create-a-tree
     *
     * @param string $repo    A GitHub repository.
     * @param array  $tree    An array of representing a tree structure.
     * @param array  $options Optional options.
     *
     * @return array An array representing the new tree.
     */
    public function createTree($repo, $tree, array $options = array())
    {
        $options = array_merge(array(
            'tree' => $tree,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/git/trees', $options);
    }
    
    /**
     * Get a single blob, fetching its content and encoding.
     * 
     * @see http://developer.github.com/v3/git/blobs/#get-a-blob
     *
     * @param string $repo     A GitHub repository.
     * @param string $blob_sha The SHA of the blob to fetch.
     * @param array  $options  Optional options.
     *
     * @return array An array representing the fetched blob.
     */
    public function blob($repo, $blob_sha, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/git/blobs/' . $blob_sha, $options);
    }
    
    /**
     * Create a blob.
     * 
     * @see http://developer.github.com/v3/git/blobs/#create-a-blob
     *
     * @param string $repo     A GitHub repository.
     * @param string $content  Content of the blob.
     * @param string $encoding The content's encoding.
     * @param array  $options  Optional options.
     *
     * @return string The new blob's SHA.
     */
    public function createBlob($repo, $content, $encoding = 'utf-8', array $options = array())
    {
        $options = array_merge(array(
            'content'  => $content,
            'encoding' => $encoding,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/git/blobs', $options);
    }
    
    /**
     * Get a tag.
     * 
     * @see http://developer.github.com/v3/git/tags/#get-a-tag
     *
     * @param string $repo    A GitHub repository.
     * @param string $tag_sha The SHA of the tag to fetch.
     * @param array  $options Optional options.
     *
     * @return array Array representing the tag.
     */
    public function tag($repo, $tag_sha, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/git/tags/' . $tag_sha, $options);
    }
    
    /**
     * Create a tag.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/git/tags/#create-a-tag-object
     *
     * @param string $repo         A GitHub repository.
     * @param string $tag          Tag string.
     * @param string $message      Tag message.
     * @param string $object_sha   SHA of the git object this is tagging.
     * @param string $type         Type of the object we're tagging. Normally this is
     *                             a `commit` but it can also be a `tree` or a `blob`.
     * @param string $tagger_name  Name of the author of the tag.
     * @param string $tagger_email Email of the author of the tag.
     * @param string $tagger_date  Timestamp of when this object was tagged.
     * @param array  $options      Optional options.
     *
     * @return array Array representing new tag.
     */
    public function createTag($repo, $tag, $message, $object_sha, $type, $tagger_name, $tagger_email, $tagger_date, array $options = array())
    {
        $options = array_merge(array(
            'tag'     => $tag,
            'message' => $message,
            'object'  => $object_sha,
            'type'    => $type,
            'tagger'  => array(
                'name'  => $tagger_name,
                'email' => $tagger_email,
                'date'  => $tagger_date,
            ),
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/git/tags', $options);
    }
}
