<?php

declare(strict_types=1);

namespace Core\UserBundle\Transformer;

use Core\UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserJsonTransformer implements UserTransformerInterface
{
    public function transformToObj(array $data): UserInterface
    {
        $user = new User();
        foreach ($data as $property => $value) {
            $setter = sprintf('set%s', ucfirst($property));
            if (method_exists($user, $setter)) {
                $user->{$setter}($value);
            }
        }

        return $user;
    }

    public function transformToRow(UserInterface $user): array
    {
        $row = [];

        foreach (get_class_methods($user) as $method) {
            if ($this->isGetter($method)) {
                $row[$this->normalizeProperty($method)] = $user->{$method}();
            }
        }

        return $row;
    }

    private function normalizeProperty(string $method): string
    {
        return strtolower(substr($method, 3));
    }

    private function isGetter(string $method): bool
    {
        return 0 === stripos($method, 'get');
    }
}