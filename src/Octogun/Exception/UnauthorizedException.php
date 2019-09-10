<?php

namespace Octogun\Exception;

class UnauthorizedException extends ErrorException
{
    protected $statusCode = 401;
}
