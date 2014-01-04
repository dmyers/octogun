<?php

namespace Octokit\Client;

use Octokit\Api;

class Say extends Api
{
    public $aliases = array(
        'octocat' => 'say',
    );
    
    /**
     * Return a nifty ASCII Octocat with GitHub wisdom
     * or your own.
     *
     * @param string $text    The text to display.
     * @param array  $options Optional options.
     *
     * @return string
     */
    public function say($text = null, array $options = array())
    {
        if (!empty($text)) {
            $options['s'] = $text;
        }
        
        return $this->request()->get('octocat', $options);
    }
}
