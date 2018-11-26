<?php

declare(strict_types=1);

namespace Core\UserBundle\Validator\Constraints;

use Core\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PasswordValidator extends ConstraintValidator
{
    /**
     * @var PasswordEncoderInterface
     */
    protected $encoder;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    public function __construct(PasswordEncoderInterface $encoder, UserManagerInterface $userManager)
    {
        $this->encoder = $encoder;
        $this->userManager = $userManager;
    }

    /**
     * @param UserInterface $entity
     * @param Constraint $constraint
     */
    public function validate($entity, Constraint $constraint): void
    {
        if (!$constraint instanceof Password) {
            throw new UnexpectedTypeException($constraint, Password::class);
        }

        if (!$entity instanceof UserInterface) {
            throw new UnexpectedTypeException($entity, UserInterface::class);
        }

        if (null === $entity || '' === $entity) {
            return;
        }

        if (null === $entity->getUsername()) {
            return;
        }

        $originalUser = $this->findUser($entity->getUsername());

        if (null === $originalUser) {
            return;
        }

        if ($this->isPasswordValid($originalUser->getPassword(), (string)$entity->getPassword())) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->atPath('password')
            ->addViolation()
        ;
    }

    private function isPasswordValid(string $original, string $input): bool
    {
        return $this->encoder->isPasswordValid($original, $input, null);
    }

    private function findUser(string $username): ?UserInterface
    {
        return $this->userManager->findOneByNickName($username);
    }
}
