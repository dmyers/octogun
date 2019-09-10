<?php

namespace Octogun\Exception;

class BadRequestException extends ErrorException
{
    protected $statusCode = 400;
}
