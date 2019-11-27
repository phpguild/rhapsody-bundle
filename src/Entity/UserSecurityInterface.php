<?php

namespace PhpGuild\RhapsodyBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface UserSecurityInterface
 */
interface UserSecurityInterface extends UserInterface, \Serializable
{
    /**
     * getFirstName
     *
     * @return string|null
     */
    public function getFirstName(): ?string;

    /**
     * setFirstName
     *
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self;

    /**
     * getLastName
     *
     * @return string|null
     */
    public function getLastName(): ?string;

    /**
     * setLastName
     *
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): self;

    /**
     * setUsername
     *
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self;

    /**
     * setPassword
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self;

    /**
     * getPlainPassword
     *
     * @return string|null
     */
    public function getPlainPassword(): ?string;

    /**
     * setPlainPassword
     *
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword): self;

    /**
     * setRoles
     *
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self;

    /**
     * setSalt
     *
     * @param string $salt
     *
     * @return $this
     */
    public function setSalt(string $salt): self;
}
