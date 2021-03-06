<?php

namespace Octogun\Client;

use Octogun\Api;

class Markdown extends Api
{
    /**
     * Render an arbitrary Markdown document.
     * 
     * @see http://developer.github.com/v3/repos/markdown/
     *
     * @param string $text    Markdown source.
     * @param array  $options Optional options.
     *
     * @return string HTML renderization.
     */
    public function markdown($text, array $options = [])
    {
        $options['text'] = $text;
        $options['accept'] = 'application/vnd.github.raw';
        
        return $this->request()->post('markdown', $options);
    }
}
