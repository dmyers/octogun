<?php

namespace Octogun\Client;

use Octogun\Api;

class Gitignore extends Api
{
    /**
     * Listing available gitignore templates.
     * 
     * These templates can be passed option when creating a repository.
     * 
     * @see http://developer.github.com/v3/gitignore/#listing-available-templates
     * 
     * @param array $options Optional options.
     * 
     * @return array List of templates.
     */
    public function gitignoreTemplates(array $options = [])
    {
        return $this->request()->get('gitignore/templates', $options);
    }
    
    /**
     * Get a gitignore template.
     * 
     * Use the raw {http://developer.github.com/v3/media/ media type} to get
     * the raw contents.
     * 
     * @see http://developer.github.com/v3/gitignore/#get-a-single-template
     * 
     * @param string $template_name Name of the template. Template names are
     *                              case sensitive, make sure to use a valid name from the 
     *                              .gitignore_templates list.
     * @param array  $options       Optional options.
     * 
     * @return array List of templates.
     */
    public function gitignoreTemplate($template_name, array $options = [])
    {
        return $this->request()->get('gitignore/templates/' . $template_name, $options);
    }
}
