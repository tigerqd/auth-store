<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Exception;

use Core\RestApiBundle\Model\ApiValidationProblem;

class ApiValidationException extends \RunTimeException
{
    /**
     * @var ApiValidationProblem
     */
    protected $problem;

    public function __construct(ApiValidationProblem $problem)
    {
        parent::__construct(
            'Exception occurred with api problem...',
            $problem->getStatusCode()
        );

        $this->problem = $problem;
    }

    public function getApiProblem(): ApiValidationProblem
    {
        return $this->problem;
    }
}
