<?php

namespace Octogun\Client;

use Octogun\Api;

class Refs extends Api
{
    public $aliases = [
        'listRefs'        => 'refs',
        'references'      => 'refs',
        'listReferences'  => 'refs',
        'reference'       => 'ref',
        'createReference' => 'createRef',
        'updateReference' => 'updateRef',
        'deleteReference' => 'deleteRef',
    ];
    
    /**
     * List all refs for a given user and repo.
     * 
     * @see http://developer.github.com/v3/git/refs/#get-all-references
     *
     * @param string $repo      A GitHub repository.
     * @param string $namespace The ref namespace.
     * @param array  $options   Optional options.
     *
     * @return array A list of references matching the repo and the namespace.
     */
    public function refs($repo, $namespace = '', array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/git/refs/' . $namespace, $options);
    }
    
    /**
     * Fetch a given reference.
     * 
     * @see http://developer.github.com/v3/git/refs/#get-a-reference
     *
     * @param string $repo    A GitHub repository.
     * @param string $ref     The ref.
     * @param array  $options Optional options.
     *
     * @return array The reference matching the given repo and the ref id.
     */
    public function ref($repo, $ref, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/git/refs/' . $ref, $options);
    }
    
    /**
     * Create a reference.
     * 
     * @see http://developer.github.com/v3/git/refs/#create-a-reference
     *
     * @param string $repo    A GitHub repository.
     * @param string $ref     The ref.
     * @param string $sha     A SHA.
     * @param array  $options Optional options.
     *
     * @return array The list of references, already containing the new one.
     */
    public function createRef($repo, $ref, $sha, array $options = [])
    {
        $options = array_merge([
            'ref' => 'refs/' . $ref,
            'sha' => $sha,
        ], $options);
        
        return $this->request()->post('repos/' . $repo . '/git/refs', $options);
    }
    
    /**
     * Update a reference.
     * 
     * @see http://developer.github.com/v3/git/refs/#update-a-reference
     *
     * @param string $repo    A GitHub repository.
     * @param string $ref     The ref.
     * @param string $sha     A SHA.
     * @param bool   $force   A flag indicating one wants to force the update to make sure the update is a fast-forward update.
     * @param array  $options Optional options.
     *
     * @return array The list of references updated.
     */
    public function updateRef($repo, $ref, $sha, $force = true, array $options = [])
    {
        $options = array_merge([
            'sha'   => $sha,
            'force' => $force,
        ], $options);
        
        return $this->request()->patch('repos/' . $repo . '/git/refs', $options);
    }
    
    /**
     * Delete a single reference.
     * 
     * @see http://developer.github.com/v3/git/refs/#delete-a-reference
     *
     * @param string $repo    A GitHub repository.
     * @param string $ref     The ref.
     * @param array  $options Optional options.
     *
     * @return bool Success.
     */
    public function deleteRef($repo, $ref, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/git/refs/' . $ref, $options);
    }
}
