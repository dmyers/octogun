<?php

namespace Octogun\Client;

use Octogun\Api;

class Emojis extends Api
{
    /**
     * List all emojis used on GitHub.
     * 
     * @see http://developer.github.com/v3/emojis/#emojis
     * 
     * @return array A list of all emojis on GitHub.
     */
    public function emojis()
    {
        return $this->request()->get('emojis');
    }
}
