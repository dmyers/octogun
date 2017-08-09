<?php

namespace Octogun\Exception;

class NotImplementedException extends ErrorException
{
    protected $statusCode = 501;
}
