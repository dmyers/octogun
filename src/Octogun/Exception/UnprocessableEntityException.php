<?php

namespace Octogun\Exception;

class UnprocessableEntityException extends ErrorException
{
    protected $statusCode = 422;
}
