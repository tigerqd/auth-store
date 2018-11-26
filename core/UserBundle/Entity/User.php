<?php

declare(strict_types=1);

namespace Core\UserBundle\Entity;

use Core\UserBundle\Validator\Constraints\Password as PasswordAssert;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @PasswordAssert(groups={"login"})
 */
class User implements UserInterface, EncoderAwareInterface
{
    public const TABLE = 'users';

    public const DEFAULT_ROLE = 'ROLE_USER';

    public const ENCODER = 'base_encoder';

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    private $firstname = '';

    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    private $lastname = '';

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"Default", "login"})
     */
    private $nickname = '';

    /**
     * @var null|int
     *
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     */
    private $age;

    /**
     * @var null|string
     *
     * @Assert\NotBlank(groups={"Default", "login"})
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "Password must be at least {{ limit }} characters long",
     *      groups={"Default", "login"}
     * )
     */
    private $password;

    /**
     * @var array
     */
    private $roles = [
        self::DEFAULT_ROLE,
    ];

    /**
     * @var null|string
     */
    private $salt;


    public function eraseCredentials(): void
    {
    }

    public function getPassword(): ?string
    {
       return $this->password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = static::DEFAULT_ROLE;

        return array_unique($roles);
    }

    public function getSalt(): ?string
    {
        return '';
    }

    public function getUsername(): string
    {
       return $this->getNickname();
    }

    public function setUsername(string $nickname): void
    {
        $this->setNickname($nickname);
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function setSalt(?string $salt): void
    {
        $this->salt = $salt;
    }

    public function getEncoderName(): ?string
    {
        return static::ENCODER;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
