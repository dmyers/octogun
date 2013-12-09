<?php

namespace Octokit\Client;

use Octokit\Api;

class Contents extends Api
{
    public $aliases = array(
        'contents'       => 'content',
        'createContent'  => 'createContents',
        'addContent'     => 'createContents',
        'addContents'    => 'createContents',
        'updateContent'  => 'updateContents',
        'deleteContent'  => 'deleteContents',
        'removeContent'  => 'deleteContents',
        'removeContents' => 'deleteContents',
    );
    
    /**
     * Receive the default Readme for a repository.
     * 
     * @see http://developer.github.com/v3/repos/contents/#get-the-readme
     * 
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return array The detail of the readme.
     */
    public function readme($repo, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/readme', $options);
    }
    
    /**
     * Receive a listing of a repository folder or the contents of a file.
     * 
     * @see http://developer.github.com/v3/repos/contents/
     * 
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return array The contents of a file or list of the files in the folder.
     */
    public function contents($repo, array $options = array())
    {
        $repo_path = $options['path'];
        
        return $this->request()->get('repos/' . $repo . '/contents/' . $repo_path, $options);
    }
    
    /**
     * Add content to a repository.
     * 
     * @see http://developer.github.com/v3/repos/contents/#create-a-file
     * 
     * @param string $repo    A GitHub repository.
     * @param string $path    A path for the new content.
     * @param string $message A commit message for adding the content.
     * @param string $content The Base64-encoded content for the file.
     * @param array  $options Optional options.
     * 
     * @return array The contents and commit info for the addition
     */
    public function createContents()
    {
        $args = func_get_args();
        $options = $args[count($args) - 1];
        $options = is_array($options) ? $options : array();
        $repo = $args[0];
        $path = $args[1];
        $message = $args[2];
        $content = $args[3];
        
        if (empty($content)) {
            throw new Exception('content required');
        }
        
        $options['content'] = trim(base64_encode($content), "\r\n");
        $options['message'] = $message;
        
        return $this->request()->put('repos/' . $repo . '/contents/' . $path, $options);
    }
    
    /**
     * Update content in a repository.
     * 
     * @see http://developer.github.com/v3/repos/contents/#update-a-file
     * 
     * @param string $repo    A GitHub repository.
     * @param string $path    A path for the content to update.
     * @param string $message A commit message for updating the content.
     * @param string $sha     The _blob sha_ of the content to update.
     * @param string $content The Base64-encoded content for the file.
     * @param array  $options Optional options.
     * 
     * @return array The contents and commit info for the update.
     */
    public function updateContents()
    {
        $args = func_get_args();
        $options = $args[count($args) - 1];
        $options = is_array($options) ? $options : array();
        $repo = $args[0];
        $path = $args[1];
        $message = $args[2];
        $sha = $args[3];
        $content = $args[4];
        
        $options = array_merge(array(
            'sha' => $sha,
        ), $options);
        
        return $this->createContent($repo, $path, $message, $content, $options);
    }
    
    /**
     * Delete content in a repository.
     * 
     * @see http://developer.github.com/v3/repos/contents/#delete-a-file
     * 
     * @param string $repo    A GitHub repository.
     * @param string $path    A path for the content to delete.
     * @param string $message A commit message for deleting the content.
     * @param string $sha     The _blob sha_ of the content to delete.
     * @param array  $options Optional options.
     * 
     * @return array The commit info for the delete
     */
    public function deleteContents($repo, $path, $message, $sha, array $options = array())
    {
        $options['message'] = $message;
        $options['sha'] = $sha;
        
        return $this->request()->delete('repos/' . $repo . '/contents/' . $path, $options);
    }
    
    /**
     * This method will provide a URL to download a tarball or zipball archive for a repository.
     * 
     * @see http://developer.github.com/v3/repos/contents/
     * 
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return string Location of the download.
     */
    public function archiveLink($repo, array $options = array())
    {
        $repo_ref = $options['ref'];
        $format = isset($options['format']) ? $options['format'] : 'tarball';
        
        $request = $this->request()->sendRequest('head', 'repos/' . $repo . '/' . $format . '/' . $repo_ref, $options);
        
        return $request->getHeader('Location');
    }
}
