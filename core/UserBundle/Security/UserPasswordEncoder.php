<?php

declare(strict_types=1);

namespace Core\UserBundle\Security;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;

class UserPasswordEncoder extends BasePasswordEncoder
{
    public function encodePassword($raw, $salt): string
    {
        return md5($raw);
    }

    public function isPasswordValid($encoded, $raw, $salt = null): bool
    {
        if ($this->isPasswordTooLong($raw)) {
            return false;
        }

        return 0 === strcmp($encoded, md5($raw));
    }
}
