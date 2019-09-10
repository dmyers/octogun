<?php

namespace Octogun\Client;

use Octogun\Api;

class Downloads extends Api
{
    public $aliases = [
        'listDownloads' => 'downloads',
    ];
    
    /**
     * List available downloads for a repository.
     * 
     * @deprecated As of December 11th, 2012: https://github.com/blog/1302-goodbye-uploads
     * 
     * @see http://developer.github.com/v3/repos/downloads/#list-downloads-for-a-repository
     *
     * @param string $repo    A Github Repository.
     * @param array  $options Optional options.
     *
     * @return array A list of available downloads.
     */
    public function downloads($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/downloads', $options);
    }
    
    /**
     * Get single download for a repository.
     * 
     * @deprecated As of December 11th, 2012: https://github.com/blog/1302-goodbye-uploads
     * 
     * @see http://developer.github.com/v3/repos/downloads/#create-a-new-download-part-1-create-the-resource
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      ID of the download.
     * @param array  $options Optional options.
     *
     * @return array A single download from the repository.
     */
    public function download($repo, $id, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/downloads/' . $id, $options);
    }
    
    /**
     * Delete a single download for a repository.
     * 
     * @deprecated As of December 11th, 2012: https://github.com/blog/1302-goodbye-uploads
     * 
     * @see http://developer.github.com/v3/repos/downloads/#delete-a-single-download
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      ID of the download.
     * @param array  $options Optional options.
     *
     * @return bool Status.
     */
    public function deleteDownload($repo, $id, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/downloads/' . $id, $options);
    }
}
