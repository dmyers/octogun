<?php

namespace Octogun\Exception;

class ServiceUnavailableException extends ErrorException
{
    protected $statusCode = 503;
}
