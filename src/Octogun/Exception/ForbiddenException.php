<?php

namespace Octogun\Exception;

class ForbiddenException extends ErrorException
{
    protected $statusCode = 403;
}
