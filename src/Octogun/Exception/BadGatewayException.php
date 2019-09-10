<?php

namespace Octogun\Exception;

class BadGatewayException extends ErrorException
{
    protected $statusCode = 502;
}
