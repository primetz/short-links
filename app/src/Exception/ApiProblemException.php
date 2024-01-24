<?php

namespace App\Exception;


use App\Api\ApiProblem;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    public function __construct(
        private readonly ApiProblem $apiProblem,
        \Throwable                  $previous = null,
        array                       $headers = [],
        int                         $code = 0
    )
    {
        $statusCode = $this->apiProblem->getStatusCode();

        $message = $this->apiProblem->getTitle();
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    public function getApiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }
}
