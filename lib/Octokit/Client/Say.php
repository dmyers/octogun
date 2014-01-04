<?php

namespace Octokit\Client;

use Octokit\Api;

class Say extends Api
{
    public $aliases = array(
        'octocat' => 'say',
    );

    public function say($text = null, array $options = array())
    {
        if (!empty($text)) {
            $options['s'] = $text;
        }
        
        return $this->request()->get('octocat', $options);
    }
}
