<?php

namespace Octogun\Exception;

class NotFoundException extends ErrorException
{
    protected $statusCode = 404;
}
