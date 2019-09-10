<?php

namespace Octogun\Client;

use Octogun\Api;

class Github extends Api
{
    /**
     * Get meta information about GitHub.com, the service.
     * 
     * @see http://developer.github.com/v3/meta/
     * 
     * @param array $options Optional options.
     * 
     * @return array Array with meta information.
     */
    public function githubMeta(array $options = array())
    {
        return $this->request()->get('meta', $options);
    }
}
