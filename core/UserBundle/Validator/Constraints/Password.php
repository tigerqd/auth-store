<?php

declare(strict_types=1);

namespace Core\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Password extends Constraint
{
    public $message = 'Incorrect user password entered.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
