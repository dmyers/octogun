<?php

namespace Octokit\Client;

use Octokit\Api;

class Authorizations extends Api
{
    public function authorizations(array $options = array())
    {
        return $this->request()->get('authorizations', $options);
    }
    
    public function authorization($number, array $options = array())
    {
        return $this->request()->get('authorizations/' . $number, $options);
    }
}
