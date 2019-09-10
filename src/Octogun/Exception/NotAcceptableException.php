<?php

namespace Octogun\Exception;

class NotAcceptableException extends ErrorException
{
    protected $statusCode = 406;
}
