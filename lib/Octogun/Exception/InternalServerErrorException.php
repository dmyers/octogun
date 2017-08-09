<?php

namespace Octogun\Exception;

class InternalServerErrorException extends ErrorException
{
    protected $statusCode = 500;
}
