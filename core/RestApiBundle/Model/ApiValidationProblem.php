<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Model;

class ApiValidationProblem
{
    private const OCCURRED_MESSAGE = 'A validation error has occurred.';

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $statusCode;

    public function __construct(array $data, int $statusCode)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->statusCode,
            'message' => static::OCCURRED_MESSAGE,
            'errors' => $this->data,
        ];
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
