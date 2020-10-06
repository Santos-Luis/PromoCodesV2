<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;

/**
 * Class User.
 */
class User extends JWTUser
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var array
     */
    private $roles;

    public function __construct(string $username = null, array $roles = null)
    {
        parent::__construct($username, $roles);

        $this->username = $username;
        $this->roles = $roles;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
