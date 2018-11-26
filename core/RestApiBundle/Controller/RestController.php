<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Controller;

use Core\RestApiBundle\Exception\ApiValidationException;
use Core\RestApiBundle\Model\ApiValidationProblem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class RestController extends Controller
{
    protected function validateRequest(?Request $request): void
    {
        if (null !== $request) {
            return;
        }

        throw new \HttpRuntimeException(
            'Failed execute, Request doest not exists',
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    protected function handleWrongValidation(Form $form): void
    {
        throw new ApiValidationException(
            new ApiValidationProblem(
                $this->getErrorMessages($form),
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }

    protected function getErrorMessages(Form $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}
