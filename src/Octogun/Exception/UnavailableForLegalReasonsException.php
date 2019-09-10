<?php

namespace Octogun\Exception;

class UnavailableForLegalReasonsException extends ErrorException
{
    protected $statusCode = 451;
}
