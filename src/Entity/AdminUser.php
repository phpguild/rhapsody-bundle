<?php

namespace PhpGuild\RhapsodyBundle\Entity;

use Gedmo\Timestampable\Traits\Timestampable;
use PhpGuild\RhapsodyBundle\Doctrine\UuidTrait;

/**
 * Class User
 */
abstract class AdminUser implements UserSecurityInterface
{
    use UuidTrait;
    use Timestampable;

    /** @var null|string */
    private $firstName;

    /** @var null|string */
    private $lastName;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $plainPassword;

    /**  @var array */
    private $roles = [ 'ROLE_ADMIN' ];

    /** @var string */
    private $salt;

    /**
     * __toString
     *
     * @return mixed
     */
    public function __toString(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    /**
     * getFirstName
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * setFirstName
     *
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): UserSecurityInterface
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * getLastName
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * setLastName
     *
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): UserSecurityInterface
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * getUsername
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * setUsername
     *
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): UserSecurityInterface
    {
        $this->username = $username;

        return $this;
    }

    /**
     * getPassword
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * setPassword
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): UserSecurityInterface
    {
        $this->password = $password;

        return $this;
    }

    /**
     * getPlainPassword
     *
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * setPlainPassword
     *
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword): UserSecurityInterface
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * getRoles
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * setRoles
     *
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): UserSecurityInterface
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * getSalt
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * setSalt
     *
     * @param string $salt
     *
     * @return $this
     */
    public function setSalt(string $salt): UserSecurityInterface
    {
        $this->salt = $salt;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * serialize
     *
     * @return string
     */
    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ]);
    }

    /**
     * unserialize
     *
     * @param string $serialized
     *
     * @return array
     */
    public function unserialize($serialized): array
    {
        return [
            $this->id,
            $this->username,
            $this->password,
            $this->salt
        ] = unserialize($serialized, [ 'allowed_classes' => false ]);
    }
}